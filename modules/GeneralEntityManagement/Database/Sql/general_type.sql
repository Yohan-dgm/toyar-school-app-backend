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
-- Sequence structure for general_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."general_type_id_seq";

CREATE SEQUENCE "public"."general_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for general_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."general_type";

CREATE TABLE "public"."general_type" (
    "id" int8 NOT NULL DEFAULT nextval('general_type_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "dependent_type_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of general_type
-- ----------------------------
INSERT INTO
    "public"."general_type"
VALUES
    (1, 'Positive', 1, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."general_type"
VALUES
    (2, 'Negative', 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table general_type
-- ----------------------------
ALTER TABLE
    "public"."general_type"
ADD
    CONSTRAINT "general_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."general_type_id_seq" OWNED BY "public"."general_type"."id";

SELECT
    setval(
        '"public"."general_type_id_seq"',
        10,
        true
    );