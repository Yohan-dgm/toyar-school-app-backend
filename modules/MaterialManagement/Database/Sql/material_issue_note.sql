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
-- Sequence structure for material_issue_note_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."material_issue_note_id_seq";

CREATE SEQUENCE "public"."material_issue_note_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for material_issue_note
-- ----------------------------
DROP TABLE IF EXISTS "public"."material_issue_note";

CREATE TABLE "public"."material_issue_note" (
    "id" int8 NOT NULL DEFAULT nextval('material_issue_note_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "material_request_note_id" int8,
    "issued_date" date,
    "issued_by" int8,
    "received_by_id" int8,
    "received_department_id" int4,
    "quantity" numeric(15, 2),
    "purpose" text COLLATE "pg_catalog"."default",
    "status_changed_by" int8,
    "material_issue_note_status_id" int4,
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Primary Key structure for table material_issue_note
-- ----------------------------
ALTER TABLE
    "public"."material_issue_note"
ADD
    CONSTRAINT "material_issue_note_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."material_issue_note_id_seq" OWNED BY "public"."material_issue_note"."id";

SELECT
    setval(
        '"public"."material_issue_note_id_seq"',
        1,
        false
    );