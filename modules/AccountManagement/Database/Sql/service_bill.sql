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
-- Sequence structure for service_bill_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."service_bill_id_seq";

CREATE SEQUENCE "public"."service_bill_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for service_bill
-- ----------------------------
DROP TABLE IF EXISTS "public"."service_bill";

CREATE TABLE "public"."service_bill" (
    "id" int8 NOT NULL DEFAULT nextval('service_bill_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "date" date,
    "bill_party" varchar(255) COLLATE "pg_catalog"."default",
    "student_id" int8,
    "applicant_id" int8,
    "subtotal" numeric(15, 2),
    "total" numeric(15, 2),
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Primary Key structure for table service_bill
-- ----------------------------
ALTER TABLE
    "public"."service_bill"
ADD
    CONSTRAINT "service_bill_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."service_bill_id_seq" OWNED BY "public"."service_bill"."id";

SELECT
    setval('"public"."service_bill_id_seq"', 1, false);