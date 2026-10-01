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

 Date: 26/07/2025 12:00:00
 */

-- ----------------------------
-- Sequence structure for edu_fb_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_id_seq";

CREATE SEQUENCE "public"."edu_fb_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb";

CREATE TABLE "public"."edu_fb" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_id_seq'::regclass),
    "student_id" int8 NOT NULL, 
    "grade_level_id" int8,
    "grade_level_class_id" int8,
    "edu_fb_category_id" int8 NOT NULL,
    "rating" decimal(3,2) DEFAULT 0.00, 
    "decline_reason" text COLLATE "pg_catalog"."default",
    "status" int8, 
    "created_by_designation" varchar(255) COLLATE "pg_catalog"."default",  
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table edu_fb
-- ----------------------------
ALTER TABLE "public"."edu_fb" ADD CONSTRAINT "edu_fb_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for performance
-- ----------------------------
 
-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_id_seq" OWNED BY "public"."edu_fb"."id";

SELECT setval('"public"."edu_fb_id_seq"', 1, false);