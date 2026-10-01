/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v1
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for receipt_voucher_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."receipt_voucher_id_seq";

CREATE SEQUENCE "public"."receipt_voucher_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for receipt_voucher
-- ----------------------------
DROP TABLE IF EXISTS "public"."receipt_voucher";

CREATE TABLE "public"."receipt_voucher" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('receipt_voucher_id_seq' :: regclass),
    "receipt_party" varchar(255) COLLATE "pg_catalog"."default",
    "student_id" int8,
    "applicant_id" int8,
    "exam_private_candidate_id" int8,
    "private_candidate_id" int8,
    "narration" text COLLATE "pg_catalog"."default",
    "amount" numeric(15, 2),
    "admission_fee_settlement" numeric(15, 2),
    "refundable_deposit_settlement" numeric(15, 2),
    "term_fee_settlement" numeric(15, 2),
    "payment_method" varchar(255) COLLATE "pg_catalog"."default",
    "bank_account_id" int8,
    "bank_deposit_date" date,
    "cash_account_id" int8,
    "cash_received_date" date,
    "check_type" varchar(255) COLLATE "pg_catalog"."default",
    "check_bank_id" int8,
    "check_number" varchar(255) COLLATE "pg_catalog"."default",
    "check_received_date" date,
    "check_date" date,
    "payment_received_by_id" int8,
    "receipt_voucher_status_type_id" int8,
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "payment_received_date" date,
    "old_bill_number" int4,
    "remarks" text COLLATE "pg_catalog"."default",
    "receipt_voucher_type" varchar(255) COLLATE "pg_catalog"."default",
    "exam_bill_id" int8,
    "applicant_proforma_invoice_id" int8,
    "material_bill_id" int8,
    "term_fee_invoice_id" int8,
    "admission_fee_invoice_id" int8,
    "refundable_deposit_id" int8,
    "sport_fee_invoice_id" int8,
    "is_reconciliation_complete" int8,
    "reconciliation_completed_at" int8,
    "late_fee_charges" numeric (15, 2),
    "sport_fee" numeric (15, 2),
    "reconciled_by" int8,
    "is_active" bool,
    "is_deleted_reqested" bool,
    "is_reconciled" bool,
    "deleted_by" int8,
    "request_delete_receipt_voucher_id" int8,
    "deleted_date" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table receipt_voucher
-- ----------------------------
ALTER TABLE
    "public"."receipt_voucher"
ADD
    CONSTRAINT "receipt_voucher_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."receipt_voucher_id_seq" OWNED BY "public"."receipt_voucher"."id";

SELECT
    setval('"public"."receipt_voucher_id_seq"', 1, false);