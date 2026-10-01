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
-- Sequence structure for applicant_proforma_invoice_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."applicant_proforma_invoice_item_id_seq";

CREATE SEQUENCE "public"."applicant_proforma_invoice_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for applicant_proforma_invoice_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."applicant_proforma_invoice_item";

CREATE TABLE "public"."applicant_proforma_invoice_item" (
    "id" int8 NOT NULL DEFAULT nextval(
        'applicant_proforma_invoice_item_id_seq' :: regclass
    ),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "applicant_proforma_invoice_id" int8,
    "invoice_type" varchar(255) COLLATE "pg_catalog"."default",
    "print_invoice_type" varchar(255) COLLATE "pg_catalog"."default",
    "print_amount" numeric(15, 2),
    "amount" numeric(15, 2)
);

-- ---------------------------
-- Primary Key structure for table applicant_proforma_invoice_item
-- ----------------------------
ALTER TABLE
    "public"."applicant_proforma_invoice_item"
ADD
    CONSTRAINT "applicant_proforma_invoice_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."applicant_proforma_invoice_item_id_seq" OWNED BY "public"."applicant_proforma_invoice_item"."id";

SELECT
    setval(
        '"public"."applicant_proforma_invoice_item_id_seq"',
        1,
        false
    );