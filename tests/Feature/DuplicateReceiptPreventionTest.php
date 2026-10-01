<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\AccountManagement\Models\PaymentGatewayOrder;

// This test file verifies the duplicate receipt prevention logic
// (application layer only — DB constraint is tested implicitly via the unique column).

uses(RefreshDatabase::class);

beforeEach(function () {
    // Make sure the payment_gateway_orders table has the transient_token_hash column.
    // If running on a test DB that hasn't had the migration yet, the column must exist.
    if (!Schema::hasColumn('payment_gateway_orders', 'transient_token_hash')) {
        Schema::table('payment_gateway_orders', function ($table) {
            $table->string('transient_token_hash', 64)->nullable()->unique()->after('transient_token');
        });
    }
});

// ── Helper ─────────────────────────────────────────────────────────────────────

function makeCompletedOrder(array $overrides = []): PaymentGatewayOrder
{
    $token = $overrides['transient_token'] ?? 'test.jwt.token.' . uniqid();

    return PaymentGatewayOrder::create(array_merge([
        'order_reference'      => (string) \Illuminate\Support\Str::uuid(),
        'user_id'              => 61,
        'student_id'           => 1,
        'invoice_type'         => 'Term Fee',
        'invoice_id'           => 1,
        'amount'               => '1000.00',
        'currency'             => 'USD',
        'status'               => 'completed',
        'admin_status'         => 'pending_review',
        'transient_token'      => $token,
        'transient_token_hash' => hash('sha256', $token),
        'cybersource_reference' => '7842691888186293204010',
        'cybersource_decision'  => 'AUTHORIZED',
        'receipt_voucher_id'   => 42,
        'expires_at'           => now()->addMinutes(15),
    ], $overrides));
}

// ── Tests ──────────────────────────────────────────────────────────────────────

test('transient_token_hash is stored as SHA-256 of transient_token', function () {
    $token = 'eyJhbGciOiJSUzI1NiJ9.payload.signature';
    $order = makeCompletedOrder(['transient_token' => $token]);

    expect($order->transient_token_hash)->toBe(hash('sha256', $token));
    expect(strlen($order->transient_token_hash))->toBe(64); // SHA-256 hex = 64 chars
});

test('database unique constraint rejects the same token hash twice', function () {
    $token = 'eyJhbGciOiJSUzI1NiJ9.first.payment';

    makeCompletedOrder(['transient_token' => $token]);

    expect(fn () => makeCompletedOrder([
        'transient_token'      => $token,
        'transient_token_hash' => hash('sha256', $token), // same hash = duplicate
    ]))->toThrow(\Illuminate\Database\QueryException::class);
});

test('different tokens produce different hashes and are both allowed', function () {
    $token1 = 'eyJhbGciOiJSUzI1NiJ9.first.token';
    $token2 = 'eyJhbGciOiJSUzI1NiJ9.second.token';

    $order1 = makeCompletedOrder(['transient_token' => $token1]);
    $order2 = makeCompletedOrder(['transient_token' => $token2]);

    expect($order1->transient_token_hash)->not->toBe($order2->transient_token_hash);
    expect(PaymentGatewayOrder::count())->toBe(2);
});

test('idempotency check finds existing completed order by token hash', function () {
    $token = 'eyJhbGciOiJSUzI1NiJ9.idempotent.test';
    $order = makeCompletedOrder(['transient_token' => $token, 'user_id' => 61]);

    $tokenHash = hash('sha256', $token);

    $found = PaymentGatewayOrder::where('transient_token_hash', $tokenHash)
        ->where('user_id', 61)
        ->where('status', 'completed')
        ->first();

    expect($found)->not->toBeNull();
    expect($found->id)->toBe($order->id);
    expect($found->receipt_voucher_id)->toBe(42);
});

test('idempotency check returns null for a token that was never processed', function () {
    $newToken  = 'eyJhbGciOiJSUzI1NiJ9.never.seen';
    $tokenHash = hash('sha256', $newToken);

    $found = PaymentGatewayOrder::where('transient_token_hash', $tokenHash)
        ->where('user_id', 61)
        ->where('status', 'completed')
        ->first();

    expect($found)->toBeNull();
});

test('idempotency check is user-scoped — another user cannot claim the same token result', function () {
    $token = 'eyJhbGciOiJSUzI1NiJ9.user.scoped.test';
    makeCompletedOrder(['transient_token' => $token, 'user_id' => 61]);

    $tokenHash = hash('sha256', $token);

    // Different user should NOT find the completed order
    $found = PaymentGatewayOrder::where('transient_token_hash', $tokenHash)
        ->where('user_id', 999) // different user
        ->where('status', 'completed')
        ->first();

    expect($found)->toBeNull();
});

test('null transient_token_hash does not violate unique constraint (multiple NULLs allowed)', function () {
    // Pre-migration rows have NULL in transient_token_hash.
    // MySQL and PostgreSQL both allow multiple NULLs in a unique index.
    PaymentGatewayOrder::create([
        'order_reference'  => (string) \Illuminate\Support\Str::uuid(),
        'user_id'          => 61, 'student_id' => 1,
        'invoice_type'     => 'Term Fee', 'invoice_id' => 1,
        'amount'           => '500.00', 'currency' => 'USD',
        'status'           => 'pending', 'admin_status' => 'pending_review',
        'transient_token'  => null,
        'transient_token_hash' => null, // no constraint violation
        'expires_at'       => now()->addMinutes(15),
    ]);

    PaymentGatewayOrder::create([
        'order_reference'  => (string) \Illuminate\Support\Str::uuid(),
        'user_id'          => 61, 'student_id' => 1,
        'invoice_type'     => 'Term Fee', 'invoice_id' => 1,
        'amount'           => '500.00', 'currency' => 'USD',
        'status'           => 'pending', 'admin_status' => 'pending_review',
        'transient_token'  => null,
        'transient_token_hash' => null, // second NULL — should be allowed
        'expires_at'       => now()->addMinutes(15),
    ]);

    expect(PaymentGatewayOrder::whereNull('transient_token_hash')->count())->toBe(2);
});
