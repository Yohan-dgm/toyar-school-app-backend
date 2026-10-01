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
-- Sequence structure for visibility_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."visibility_type_id_seq";

CREATE SEQUENCE "public"."visibility_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ---------------------------
-- Table structure for visibility_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."visibility_type";

CREATE TABLE "public"."visibility_type" (
    "id" int8 NOT NULL DEFAULT nextval(
        'visibility_type_id_seq' :: regclass
    ),
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "sequential_order" int4
);

-- ----------------------------
-- Records of visibility_type
-- ----------------------------
INSERT INTO
    "public"."visibility_type"
VALUES
    (
        1,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Principal & Created Educator',
        1
    );

INSERT INTO
    "public"."visibility_type"
VALUES
    (
        2,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'All Educators',
        2
    );

INSERT INTO
    "public"."visibility_type"
VALUES
    (
        3,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Private',
        3
    );

INSERT INTO
    "public"."visibility_type"
VALUES
    (
        4,
        NULL,
        NULL,
        '2025-01-01 10:49:46',
        NULL,
        'Public',
        4
    );

-- ----------------------------
-- Primary Key structure for table visibility_type
-- ----------------------------
ALTER TABLE
    "public"."visibility_type"
ADD
    CONSTRAINT "visibility_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."visibility_type_id_seq" OWNED BY "public"."visibility_type"."id";

SELECT
    setval(
        '"public"."visibility_type_id_seq"',
        4,
        true
    );