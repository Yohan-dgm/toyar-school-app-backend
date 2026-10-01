/*
 Navicat Premium Data Transfer
 
 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 10/12/2024 06:25:55
 */
-- ----------------------------
-- Sequence structure for class_section_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."class_section_id_seq";

CREATE SEQUENCE "public"."class_section_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for class_section
-- ----------------------------
DROP TABLE IF EXISTS "public"."class_section";

CREATE TABLE "public"."class_section" (
    "id" int8 NOT NULL DEFAULT nextval('class_section_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    -- employee_id
    "section_head_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of class_section
-- ----------------------------
INSERT INTO
    "public"."class_section"
VALUES
    (1, 'Grade 1-5', 11, NULL, NULL);

INSERT INTO
    "public"."class_section"
VALUES
    (2, 'Grade 6-8', 15, NULL, NULL);

INSERT INTO
    "public"."class_section"
VALUES
    (3, 'Grade 9-10', 18, NULL, NULL);

INSERT INTO
    "public"."class_section"
VALUES
    (4, 'Grade 11-12', 35, NULL, NULL);

INSERT INTO
    "public"."class_section"
VALUES
    (5, 'Early years', 9, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table class_section
-- ----------------------------
ALTER TABLE
    "public"."class_section"
ADD
    CONSTRAINT "class_section_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."class_section_id_seq" OWNED BY "public"."class_section"."id";

SELECT
    setval(
        '"public"."class_section_id_seq"',
        5,
        true
    );