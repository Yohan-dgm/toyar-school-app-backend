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
-- Sequence structure for material_bill_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."material_bill_id_seq";

CREATE SEQUENCE "public"."material_bill_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for material_bill
-- ----------------------------
DROP TABLE IF EXISTS "public"."material_bill";

CREATE TABLE "public"."material_bill" (
    "id" int8 NOT NULL DEFAULT nextval('material_bill_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "date" date,
    "student_id" int8,
    "applicant_id" int8,
    "invoice_party" varchar(255) COLLATE "pg_catalog"."default",
    "items_total" numeric(15, 2),
    "service_charges_total" numeric(15, 2),
    "subtotal_before_discount" numeric(15, 2),
    "discount_total" numeric(15, 2),
    "subtotal_after_discount" numeric(15, 2),
    "tax_total" numeric(15, 2),
    "bill_total" numeric(15, 2),
    "order_notes" text COLLATE "pg_catalog"."default",
    "office_notes" text COLLATE "pg_catalog"."default",
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "is_material_bill_complete" bool,
    "material_bill_status_id" int8
);

-- ----------------------------
-- Primary Key structure for table material_bill
-- ----------------------------
ALTER TABLE
    "public"."material_bill"
ADD
    CONSTRAINT "material_bill_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."material_bill_id_seq" OWNED BY "public"."material_bill"."id";

SELECT
    setval('"public"."material_bill_id_seq"', 1, false);