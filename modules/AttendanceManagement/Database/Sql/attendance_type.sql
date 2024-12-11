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
-- Sequence structure for attendance_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."attendance_type_id_seq";

CREATE SEQUENCE "public"."attendance_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for attendance_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."attendance_type";

CREATE TABLE "public"."attendance_type" (
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('attendance_type_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default"
);

-- ----------------------------
-- Records of attendance_type
-- ----------------------------
INSERT INTO
    "public"."attendance_type"
VALUES
    (NULL, NULL, NULL, NULL, 1, 'In');

INSERT INTO
    "public"."attendance_type"
VALUES
    (NULL, NULL, NULL, NULL, 2, 'Out');

INSERT INTO
    "public"."attendance_type"
VALUES
    (NULL, NULL, NULL, NULL, 3, 'Leave');

INSERT INTO
    "public"."attendance_type"
VALUES
    (NULL, NULL, NULL, NULL, 4, 'Absent');

-- ----------------------------
-- Primary Key structure for table attendance_type
-- ----------------------------
ALTER TABLE
    "public"."attendance_type"
ADD
    CONSTRAINT "attendance_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."attendance_type_id_seq" OWNED BY "public"."attendance_type"."id";

SELECT
    setval('"public"."attendance_type_id_seq"', 4, true);