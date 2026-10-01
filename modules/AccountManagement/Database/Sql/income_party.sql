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
-- Sequence structure for income_party_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."income_party_id_seq";

CREATE SEQUENCE "public"."income_party_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for income_party
-- ----------------------------
DROP TABLE IF EXISTS "public"."income_party";

CREATE TABLE "public"."income_party" (
    "id" int8 NOT NULL DEFAULT nextval('income_party_id_seq' :: regclass),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "income_party_type" varchar(255) COLLATE "pg_catalog"."default",
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
-- Primary Key structure for table income_party
-- ----------------------------
ALTER TABLE
    "public"."income_party"
ADD
    CONSTRAINT "income_party_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."income_party_id_seq" OWNED BY "public"."income_party"."id";

SELECT
    setval(
        '"public"."income_party_id_seq"',
        1,
        false
    );