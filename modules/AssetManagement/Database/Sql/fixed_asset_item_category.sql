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
-- Sequence structure for fixed_asset_item_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."fixed_asset_item_category_id_seq";

CREATE SEQUENCE "public"."fixed_asset_item_category_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for fixed_asset_item_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."fixed_asset_item_category";

CREATE TABLE "public"."fixed_asset_item_category" (
    "id" int8 NOT NULL DEFAULT nextval('fixed_asset_item_category_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "fixed_asset_item_type_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of fixed_asset_item_category
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table fixed_asset_item_category
-- ----------------------------
ALTER TABLE
    "public"."fixed_asset_item_category"
ADD
    CONSTRAINT "fixed_asset_item_category_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."fixed_asset_item_category_id_seq" OWNED BY "public"."fixed_asset_item_category"."id";

SELECT
    setval(
        '"public"."fixed_asset_item_category_id_seq"',
        1,
        false
    );