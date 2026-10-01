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
 
 Date: 19/06/2026 11:55:12
 */

-- ----------------------------
-- Sequence structure for payment_gateway_orders_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."payment_gateway_orders_id_seq";

CREATE SEQUENCE "public"."payment_gateway_orders_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for payment_gateway_orders
-- ----------------------------
DROP TABLE IF EXISTS "public"."payment_gateway_orders";

CREATE TABLE "public"."payment_gateway_orders" (
    "id" int8 NOT NULL DEFAULT nextval('payment_gateway_orders_id_seq' :: regclass),
    "order_reference" uuid NOT NULL,
    "user_id" int8 NOT NULL,
    "student_id" int8 NOT NULL,
    "invoice_type" varchar(255) NOT NULL,
    "invoice_id" int8 NOT NULL,
    "amount" numeric(10, 2) NOT NULL,
    "currency" varchar(3) NOT NULL DEFAULT 'LKR',
    "status" varchar(255) NOT NULL DEFAULT 'pending' CHECK ("status" in ('pending', 'completed', 'failed', 'expired', 'gateway_timeout')),
    "admin_status" varchar(255) NOT NULL DEFAULT 'pending_review' CHECK ("admin_status" in ('pending_review', 'approved', 'rejected')),
    "admin_approved_by" int8,
    "admin_approved_at" timestamp(0),
    "admin_notes" text,
    "transient_token" text,
    "cybersource_reference" varchar(255),
    "cybersource_decision" varchar(255),
    "receipt_voucher_id" int8,
    "expires_at" timestamp(0) NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of payment_gateway_orders
-- ---------------------------- 

-- ----------------------------
-- Indexes structure for table payment_gateway_orders
-- ----------------------------
CREATE UNIQUE INDEX "payment_gateway_orders_order_reference_unique" ON "public"."payment_gateway_orders" ("order_reference");
CREATE INDEX "payment_gateway_orders_user_id_index" ON "public"."payment_gateway_orders" ("user_id");
CREATE INDEX "payment_gateway_orders_student_id_index" ON "public"."payment_gateway_orders" ("student_id");
CREATE INDEX "payment_gateway_orders_status_index" ON "public"."payment_gateway_orders" ("status");
CREATE INDEX "payment_gateway_orders_admin_status_index" ON "public"."payment_gateway_orders" ("admin_status");

-- ----------------------------
-- Primary Key structure for table payment_gateway_orders
-- ----------------------------
ALTER TABLE
    "public"."payment_gateway_orders"
ADD
    CONSTRAINT "payment_gateway_orders_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."payment_gateway_orders_id_seq" OWNED BY "public"."payment_gateway_orders"."id";

SELECT
    setval(
        '"public"."payment_gateway_orders_id_seq"',
        1,
        false
    );

-- ----------------------------
-- Migration record
-- ----------------------------
INSERT INTO "public"."migrations" ("migration", "batch") 
VALUES ('2026_06_18_162704_create_payment_gateway_orders_table', (SELECT COALESCE(MAX(batch),0)+1 FROM "public"."migrations"));