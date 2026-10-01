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
-- Sequence structure for applicant_proforma_invoice_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."applicant_proforma_invoice_id_seq";

CREATE SEQUENCE "public"."applicant_proforma_invoice_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for applicant_proforma_invoice
-- ----------------------------
DROP TABLE IF EXISTS "public"."applicant_proforma_invoice";

CREATE TABLE "public"."applicant_proforma_invoice" (
    "id" int8 NOT NULL DEFAULT nextval('applicant_proforma_invoice_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "date" date,
    "applicant_id" int8,
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
    "is_applicant_proforma_invoice_complete" bool,
    "applicant_proforma_invoice_status_id" int8
);

-- ----------------------------
-- Primary Key structure for table applicant_proforma_invoice
-- ----------------------------
ALTER TABLE
    "public"."applicant_proforma_invoice"
ADD
    CONSTRAINT "applicant_proforma_invoice_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."applicant_proforma_invoice_id_seq" OWNED BY "public"."applicant_proforma_invoice"."id";

SELECT
    setval(
        '"public"."applicant_proforma_invoice_id_seq"',
        1,
        false
    );