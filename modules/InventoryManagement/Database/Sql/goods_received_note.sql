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
-- Sequence structure for goods_received_note_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."goods_received_note_id_seq";

CREATE SEQUENCE "public"."goods_received_note_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for goods_received_note
-- ----------------------------
DROP TABLE IF EXISTS "public"."goods_received_note";

CREATE TABLE "public"."goods_received_note" (
    "id" int8 NOT NULL DEFAULT nextval('goods_received_note_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "date" date,
    "reference_number" varchar(255) COLLATE "pg_catalog"."default",
    "purchase_order_id" int8,
    "is_receival_complete" varchar(255) COLLATE "pg_catalog"."default",
    "office_notes" text COLLATE "pg_catalog"."default",
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_financial_year" varchar(32) COLLATE "pg_catalog"."default",
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default",
    "is_goods_received_note_complete" bool,
    "goods_received_note_status_id" int8
);

-- ----------------------------
-- Primary Key structure for table goods_received_note
-- ----------------------------
ALTER TABLE
    "public"."goods_received_note"
ADD
    CONSTRAINT "goods_received_note_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."goods_received_note_id_seq" OWNED BY "public"."goods_received_note"."id";

SELECT
    setval(
        '"public"."goods_received_note_id_seq"',
        1,
        false
    );