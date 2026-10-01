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
-- Sequence structure for supplier_bill_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."supplier_bill_item_id_seq";

CREATE SEQUENCE "public"."supplier_bill_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for supplier_bill_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."supplier_bill_item";

CREATE TABLE "public"."supplier_bill_item" (
    "id" int8 NOT NULL DEFAULT nextval('supplier_bill_item_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "supplier_bill_id" int8,
    "item_type" varchar(255) COLLATE "pg_catalog"."default",
    "purchase_order_id" int8,
    "purchase_order_item_id" int8,
    "ordered_quantity" numeric(15, 2),
    "item_unit" varchar(255) COLLATE "pg_catalog"."default",
    "unit_price" numeric(15, 2),
    "billed_quantity" numeric(15, 2),
    "item_total" numeric(15, 2),
    "is_supplier_bill_item_complete" bool
);

-- ---------------------------
-- Primary Key structure for table supplier_bill_item
-- ----------------------------
ALTER TABLE
    "public"."supplier_bill_item"
ADD
    CONSTRAINT "supplier_bill_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."supplier_bill_item_id_seq" OWNED BY "public"."supplier_bill_item"."id";

SELECT
    setval(
        '"public"."supplier_bill_item_id_seq"',
        1,
        false
    );