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
-- Sequence structure for edu_fd_evaluation_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fd_evaluation_id_seq";

CREATE SEQUENCE "public"."edu_fd_evaluation_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fd_evaluation
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fd_evaluation";

CREATE TABLE "public"."edu_fd_evaluation" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fd_evaluation_id_seq'::regclass),
    "student_id" int8 NOT NULL, 
    "edu_fb_id" int8 NOT NULL,
    "edu_fd_evaluation_type_id" int8 NOT NULL, 
    "reviewer_feedback" text COLLATE "pg_catalog"."default", 
    "decline_reason" text COLLATE "pg_catalog"."default",  
    "is_parent_visible" int8,
    "is_active" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table edu_fd_evaluation
-- ----------------------------
ALTER TABLE "public"."edu_fd_evaluation" ADD CONSTRAINT "edu_fd_evaluation_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for performance
-- ----------------------------
 
-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fd_evaluation_id_seq" OWNED BY "public"."edu_fd_evaluation"."id";

SELECT setval('"public"."edu_fd_evaluation_id_seq"', 1, false);