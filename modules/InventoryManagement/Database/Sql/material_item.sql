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
-- Sequence structure for material_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."material_item_id_seq";

CREATE SEQUENCE "public"."material_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for material_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."material_item";

CREATE TABLE "public"."material_item" (
    "id" int8 NOT NULL DEFAULT nextval('material_item_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "material_item_type_id" int8,
    "material_item_category_id" int8,
    "material_item_sub_category_id" int8,
    "unit_id" int8,
    "reorder_level" numeric(15, 2),
    "is_expirable" bool,
    "unit_price" numeric(15, 2),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Records of material_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table material_item
-- ----------------------------
ALTER TABLE
    "public"."material_item"
ADD
    CONSTRAINT "material_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."material_item_id_seq" OWNED BY "public"."material_item"."id";

SELECT
    setval(
        '"public"."material_item_id_seq"',
        1,
        false
    );