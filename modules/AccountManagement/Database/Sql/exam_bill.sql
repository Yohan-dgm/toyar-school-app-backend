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
-- Sequence structure for exam_bill_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."exam_bill_id_seq";

CREATE SEQUENCE "public"."exam_bill_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for exam_bill
-- ----------------------------
DROP TABLE IF EXISTS "public"."exam_bill";

CREATE TABLE "public"."exam_bill" (
    "id" int8 NOT NULL DEFAULT nextval('exam_bill_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "date" date,
    "bill_party" int8,
    "student_id" int8,
    "exam_private_candidate_id" int8,
    "bill_notes" text COLLATE "pg_catalog"."default",
    "office_notes" text COLLATE "pg_catalog"."default",
    "additional_service_charge" numeric(15, 2),
    "exam_subjects_total" numeric(15, 2),
    "exam_service_charges_total" numeric(15, 2),
    "subtotal" numeric(15, 2),
    "exam_bill_discount" numeric(15, 2),
    "total" numeric(15, 2),
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Primary Key structure for table exam_bill
-- ----------------------------
ALTER TABLE
    "public"."exam_bill"
ADD
    CONSTRAINT "exam_bill_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."exam_bill_id_seq" OWNED BY "public"."exam_bill"."id";

SELECT
    setval('"public"."exam_bill_id_seq"', 1, false);