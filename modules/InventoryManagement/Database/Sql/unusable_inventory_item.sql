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
-- Sequence structure for unusable_inventory_item_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."unusable_inventory_item_id_seq";

CREATE SEQUENCE "public"."unusable_inventory_item_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for unusable_inventory_item
-- ----------------------------
DROP TABLE IF EXISTS "public"."unusable_inventory_item";

CREATE TABLE "public"."unusable_inventory_item" (
    "id" int8 NOT NULL DEFAULT nextval('unusable_inventory_item_id_seq' :: regclass),
    "inventory_item_id" int8,
    "unusable_quantity" numeric(15, 2),
    "unusable_reason" text COLLATE "pg_catalog"."default",
    "unusable_marked_date" date,
    "unusable_marked_by" int8,
    "unusable_inventory_item_status_type_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of unusable_inventory_item
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table unusable_inventory_item
-- ----------------------------
ALTER TABLE
    "public"."unusable_inventory_item"
ADD
    CONSTRAINT "unusable_inventory_item_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."unusable_inventory_item_id_seq" OWNED BY "public"."unusable_inventory_item"."id";

SELECT
    setval(
        '"public"."unusable_inventory_item_id_seq"',
        1,
        false
    );