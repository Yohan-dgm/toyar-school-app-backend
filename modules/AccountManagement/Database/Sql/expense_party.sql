/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 09/12/2024 11:59:18
 */
-- ----------------------------
-- Sequence structure for expense_party_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."expense_party_id_seq";

CREATE SEQUENCE "public"."expense_party_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for expense_party
-- ----------------------------
DROP TABLE IF EXISTS "public"."expense_party";

CREATE TABLE "public"."expense_party" (
    "id" int8 NOT NULL DEFAULT nextval('expense_party_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "expense_party_type" varchar(255) COLLATE "pg_catalog"."default",
    "person_title_id" int8,
    "phone" varchar(255) COLLATE "pg_catalog"."default",
    "email" varchar(255) COLLATE "pg_catalog"."default",
    "full_address" text COLLATE "pg_catalog"."default",
    "country_id" int8,
    "name_with_title" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_prefix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number_digits" int8,
    "serial_number_current_year" int4,
    "serial_number_suffix" varchar(255) COLLATE "pg_catalog"."default",
    "serial_number" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Primary Key structure for table expense_party
-- ----------------------------
ALTER TABLE
    "public"."expense_party"
ADD
    CONSTRAINT "expense_party_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."expense_party_id_seq" OWNED BY "public"."expense_party"."id";

SELECT
    setval(
        '"public"."expense_party_id_seq"',
        1,
        false
    );