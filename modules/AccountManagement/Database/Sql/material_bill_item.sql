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
-- Sequence structure for material_bill_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."material_bill_item_id_seq";

CREATE SEQUENCE "public"."material_bill_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for material_bill_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."material_bill_item";

CREATE TABLE "public"."material_bill_item" (
    "id" int8 NOT NULL DEFAULT nextval('material_bill_item_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "material_bill_id" int8,
    "material_item_id" int8,
    "item_quantity" numeric(15, 2),
    "print_description" text COLLATE "pg_catalog"."default",
    "print_quantity" numeric(15, 2),
    "print_unit" varchar(255) COLLATE "pg_catalog"."default",
    "ordered_quantity" numeric(15, 2),
    "billed_quantity" numeric(15, 2),
    "issued_quantity" numeric(15, 2),
    "unit_price" numeric(15, 2),
    "item_total" numeric(15, 2),
    "is_material_bill_item_complete" bool
);

-- ---------------------------
-- Primary Key structure for table material_bill_item
-- ----------------------------
ALTER TABLE
    "public"."material_bill_item"
ADD
    CONSTRAINT "material_bill_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."material_bill_item_id_seq" OWNED BY "public"."material_bill_item"."id";

SELECT
    setval(
        '"public"."material_bill_item_id_seq"',
        1,
        false
    );