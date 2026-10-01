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
-- Sequence structure for purchase_order_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."purchase_order_item_id_seq";

CREATE SEQUENCE "public"."purchase_order_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for purchase_order_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."purchase_order_item";

CREATE TABLE "public"."purchase_order_item" (
    "id" int8 NOT NULL DEFAULT nextval('purchase_order_item_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "purchase_order_id" int8,
    "item_type" varchar(255) COLLATE "pg_catalog"."default",
    "material_item_id" int8,
    "item_quantity" numeric(15, 2),
    "print_description" text COLLATE "pg_catalog"."default",
    "print_quantity" numeric(15, 2),
    "print_unit" varchar(255) COLLATE "pg_catalog"."default",
    "ordered_quantity" numeric(15, 2),
    "billed_quantity" numeric(15, 2),
    "received_quantity" numeric(15, 2),
    "is_purchase_order_item_complete" bool
);

-- ---------------------------
-- Primary Key structure for table purchase_order_item
-- ----------------------------
ALTER TABLE
    "public"."purchase_order_item"
ADD
    CONSTRAINT "purchase_order_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."purchase_order_item_id_seq" OWNED BY "public"."purchase_order_item"."id";

SELECT
    setval(
        '"public"."purchase_order_item_id_seq"',
        1,
        false
    );