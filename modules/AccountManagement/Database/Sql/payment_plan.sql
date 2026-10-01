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
-- Sequence structure for payment_plan_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."payment_plan_id_seq";

CREATE SEQUENCE "public"."payment_plan_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for payment_plan
-- ----------------------------
DROP TABLE IF EXISTS "public"."payment_plan";

CREATE TABLE "public"."payment_plan" (
    "id" int8 NOT NULL DEFAULT nextval('payment_plan_id_seq' :: regclass),
    "student_id" int8,
    "grade_level_id" int8,
    "main_program_id" int8,
    "main_program_rate_id" int8,
    "main_program_rate" numeric(15, 2),
    "main_program_down_payment" numeric(15, 2),
    "admission_rate_id" int8,
    "admission_rate" numeric(15, 2),
    "admission_down_payment" numeric(15, 2),
    "refundable_deposit_rate_id" int8,
    "refundable_deposit_rate" numeric(15, 2),
    "refundable_deposit_down_payment" numeric(15, 2),
    "subtotal" numeric(15, 2),
    "discount" numeric(15, 2),
    "subtotal_after_discount" numeric(15, 2),
    "total" numeric(15, 2),
    "agreed_number_of_installments" int4,
    "pending_number_of_installments" int4,
    "should_add_installment_interest" bool,
    "installment_interest_factor" numeric(15, 2),
    "should_add_late_payment_interest" bool,
    "late_payment_interest_factor" numeric(15, 2),
    "total_due" numeric(15, 2),
    "is_first_down_payment_bill_generated" bool,
    "first_down_payment_bill_id" int8,
    "is_payment_complete" bool,
    "is_active" bool,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of payment_plan
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table payment_plan
-- ----------------------------
ALTER TABLE
    "public"."payment_plan"
ADD
    CONSTRAINT "payment_plan_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."payment_plan_id_seq" OWNED BY "public"."payment_plan"."id";

SELECT
    setval(
        '"public"."payment_plan_id_seq"',
        1,
        false
    );