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
-- Sequence structure for refundable_deposit_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."refundable_deposit_item_id_seq";

CREATE SEQUENCE "public"."refundable_deposit_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for refundable_deposit_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."refundable_deposit_item";

CREATE TABLE "public"."refundable_deposit_item" (
    "id" int8 NOT NULL DEFAULT nextval('refundable_deposit_item_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "refundable_deposit_id" int8,
    "school_fee_id" int8,
    "description" text COLLATE "pg_catalog"."default",
    "item_total" numeric(15, 2),
    "is_refundable_deposit_item_complete" bool
);

-- ---------------------------
-- Primary Key structure for table refundable_deposit_item
-- ----------------------------
ALTER TABLE
    "public"."refundable_deposit_item"
ADD
    CONSTRAINT "refundable_deposit_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."refundable_deposit_item_id_seq" OWNED BY "public"."refundable_deposit_item"."id";

SELECT
    setval(
        '"public"."refundable_deposit_item_id_seq"',
        1,
        false
    );