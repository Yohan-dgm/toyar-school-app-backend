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
 
 Date: 09/12/2024 09:41:15
 */
-- ----------------------------
-- Sequence structure for payment_plan_status_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."payment_plan_status_id_seq";

CREATE SEQUENCE "public"."payment_plan_status_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for payment_plan_status
-- ----------------------------
DROP TABLE IF EXISTS "public"."payment_plan_status";

CREATE TABLE "public"."payment_plan_status" (
    "payment_plan_id" int8,
    "payment_plan_status_type_id" int8,
    "notes" text COLLATE "pg_catalog"."default",
    "status_changed_by_id" int8,
    "is_active" bool,
    "updated_by" int8,
    "created_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'payment_plan_status_id_seq' :: regclass
    )
);

-- ---------------------------
-- Records of payment_plan_status
-- ----------------------------
-- ----------------------------
-- Primary Key structure for table payment_plan_status
-- ----------------------------
ALTER TABLE
    "public"."payment_plan_status"
ADD
    CONSTRAINT "payment_plan_status_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."payment_plan_status_id_seq" OWNED BY "public"."payment_plan_status"."id";

SELECT
    setval(
        '"public"."payment_plan_status_id_seq"',
        1,
        false
    );