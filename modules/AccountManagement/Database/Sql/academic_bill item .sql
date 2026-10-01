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
-- Sequence structure for academic_bill_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."academic_bill_item_id_seq";

CREATE SEQUENCE "public"."academic_bill_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for academic_bill_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."academic_bill_item";

CREATE TABLE "public"."academic_bill_item" (
    "id" int8 NOT NULL DEFAULT nextval('academic_bill_item_id_seq' :: regclass),
    "program_id" int8,
    "academic_bill_id" int8,
    "bill_item_type" varchar(255) COLLATE "pg_catalog"."default",
    "payment_plan_down_payment_amount" numeric(15, 2),
    "payment_plan_installment_amount" numeric(15, 2),
    "payment_plan_late_charge_amount" numeric(15, 2),
    "sequential_order" int4,
    "description" text,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of academic_bill_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table academic_bill_item
-- ----------------------------
ALTER TABLE
    "public"."academic_bill_item"
ADD
    CONSTRAINT "academic_bill_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."academic_bill_item_id_seq" OWNED BY "public"."academic_bill_item"."id";

SELECT
    setval(
        '"public"."academic_bill_item_id_seq"',
        1,
        false
    );