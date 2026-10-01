/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for purchase_request_note_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_request_note_id_seq";

CREATE SEQUENCE "public"."purchase_request_note_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for purchase_request_note
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_request_note";

CREATE TABLE "public"."purchase_request_note" (
    "id" int8 NOT NULL DEFAULT nextval('purchase_request_note_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "item_type" varchar(255) COLLATE "pg_catalog"."default",
    "material_item_id" int8,
    "service_item_description" text COLLATE "pg_catalog"."default",
    "date" date,
    "quantity" numeric(15, 2),
    "requested_by_id" int8,
    "requirement" text COLLATE "pg_catalog"."default",
    "purchase_request_note_status_id" int4,
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "purchase_order_id" int8,
    "purchase_order_item_id" int8
);

-- ----------------------------
-- Primary Key structure for table purchase_request_note
-- ----------------------------
ALTER TABLE
    "public"."purchase_request_note"
ADD
    CONSTRAINT "purchase_request_note_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_request_note_id_seq" OWNED BY "public"."purchase_request_note"."id";

SELECT
    setval(
        '"public"."purchase_request_note_id_seq"',
        1,
        false
    );