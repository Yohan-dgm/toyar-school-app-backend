/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v5
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 21/12/2024 11:47:35
 */
-- ----------------------------
-- Sequence structure for applicant_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."applicant_id_seq";

CREATE SEQUENCE "public"."applicant_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for applicant
-- ----------------------------
DROP TABLE IF EXISTS "public"."applicant";

CREATE TABLE "public"."applicant" (
    "id" int8 NOT NULL DEFAULT nextval('applicant_id_seq' :: regclass),
    "full_name" text COLLATE "pg_catalog"."default",
    "gender" varchar(255) COLLATE "pg_catalog"."default",
    "full_name_with_title" text COLLATE "pg_catalog"."default",
    "date_of_birth" date,
    "nationality_id" int8,
    "religion_id" int8,
    "grade_level_id" int8,
    "full_address" varchar(255) COLLATE "pg_catalog"."default",
    "phone" varchar(255) COLLATE "pg_catalog"."default",
    "email" varchar(255) COLLATE "pg_catalog"."default",
    "school_studied_before" varchar(255) COLLATE "pg_catalog"."default",
    "special_conditions" text COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "applicant_number_prefix" varchar COLLATE "pg_catalog"."default",
    "applicant_number_current_year" varchar COLLATE "pg_catalog"."default",
    "applicant_number_digits" int8,
    "applicant_number" varchar(255) COLLATE "pg_catalog"."default",
    "has_converted_to_student" bool,
    "approved_admission_fee" numeric(15, 2),
    "approved_refundable_deposit" numeric(15, 2),
    "approved_term_payment" numeric(15, 2),
    "start_term_id" int8
);

-- ----------------------------
-- Primary Key structure for table applicant
-- ----------------------------
ALTER TABLE
    "public"."applicant"
ADD
    CONSTRAINT "applicant_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."applicant_id_seq" OWNED BY "public"."applicant"."id";

SELECT
    setval(
        '"public"."applicant_id_seq"',
        1,
        false
    );