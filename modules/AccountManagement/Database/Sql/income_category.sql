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
-- Sequence structure for income_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."income_category_id_seq";

CREATE SEQUENCE "public"."income_category_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for income_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."income_category";

CREATE TABLE "public"."income_category" (
    "id" int8 NOT NULL DEFAULT nextval('income_category_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "income_type_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table income_category
-- ----------------------------
ALTER TABLE
    "public"."income_category"
ADD
    CONSTRAINT "income_category_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."income_category_id_seq" OWNED BY "public"."income_category"."id";

SELECT
    setval(
        '"public"."income_category_id_seq"',
        1,
        false
    );