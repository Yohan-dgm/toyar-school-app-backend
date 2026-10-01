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
-- Sequence structure for edu_fd_evaluation_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fd_evaluation_type_id_seq";

CREATE SEQUENCE "public"."edu_fd_evaluation_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fd_evaluation_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fd_evaluation_type";

CREATE TABLE "public"."edu_fd_evaluation_type" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fd_evaluation_type_id_seq'::regclass), 
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "status_code" int8 NOT NULL,
    "description" text COLLATE "pg_catalog"."default",
    "is_active" boolean DEFAULT true, 
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fd_evaluation_type (Predefined evaluation statuses)
-- ----------------------------
INSERT INTO "public"."edu_fd_evaluation_type" ("id", "name", "status_code", "description", "is_active", "created_at", "updated_at") VALUES
(1, 'Under Observation', 1, 'Student is under observation for feedback evaluation', true, NOW(), NOW()),
(2, 'Accept', 2, 'Feedback has been accepted and approved', true, NOW(), NOW()),
(3, 'Decline', 3, 'Feedback has been declined or rejected', true, NOW(), NOW()),
(4, 'Aware Parents', 4, 'Parents have been made aware of the feedback', true, NOW(), NOW()),
(5, 'Assigning to Counselor', 5, 'Feedback is being assigned to a counselor', true, NOW(), NOW()),
(6, 'Correction Required', 6, 'Feedback requires correction or revision', true, NOW(), NOW());

-- ----------------------------
-- Primary Key structure for table edu_fd_evaluation_type
-- ----------------------------
ALTER TABLE "public"."edu_fd_evaluation_type" ADD CONSTRAINT "edu_fd_evaluation_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for performance
-- ----------------------------
 
-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fd_evaluation_type_id_seq" OWNED BY "public"."edu_fd_evaluation_type"."id";

SELECT setval('"public"."edu_fd_evaluation_type_id_seq"', 1, false);