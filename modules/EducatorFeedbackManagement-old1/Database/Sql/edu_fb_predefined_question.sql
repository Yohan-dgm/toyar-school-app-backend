
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
-- Sequence structure for edu_fb_predefined_question_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_predefined_question_id_seq";

CREATE SEQUENCE "public"."edu_fb_predefined_question_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_predefined_question
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_predefined_question";

CREATE TABLE "public"."edu_fb_predefined_question" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_predefined_question_id_seq' :: regclass),
    "question" text COLLATE "pg_catalog"."default",
    "edu_fb_category_id" int8,
    "edu_fb_answer_type_id" int8,
    "is_active" boolean DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_predefined_question
-- ---------------------------- 
-- ----------------------------
-- Primary Key structure for table edu_fb_predefined_question
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_predefined_question"
ADD
    CONSTRAINT "edu_fb_predefined_question_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_predefined_question_id_seq" OWNED BY "public"."edu_fb_predefined_question"."id";

SELECT
    setval( '"public"."edu_fb_predefined_question_id_seq"', 1,  false );
