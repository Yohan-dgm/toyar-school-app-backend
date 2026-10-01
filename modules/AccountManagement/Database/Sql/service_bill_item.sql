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
-- Sequence structure for service_bill_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."service_bill_item_id_seq";

CREATE SEQUENCE "public"."service_bill_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for service_bill_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."service_bill_item";

CREATE TABLE "public"."service_bill_item" (
    "id" int8 NOT NULL DEFAULT nextval('service_bill_item_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "service_bill_id" int8,
    "service_item_id" int8,
    "description" text COLLATE "pg_catalog"."default",
    "quantity" numeric(15, 2),
    "rate_id" int8,
    "rate" numeric(15, 2),
    "subtotal" numeric(15, 2),
    "total" numeric(15, 2)
);

-- ----------------------------
-- Primary Key structure for table service_bill_item
-- ----------------------------
ALTER TABLE
    "public"."service_bill_item"
ADD
    CONSTRAINT "service_bill_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."service_bill_item_id_seq" OWNED BY "public"."service_bill_item"."id";

SELECT
    setval('"public"."service_bill_item_id_seq"', 1, false);