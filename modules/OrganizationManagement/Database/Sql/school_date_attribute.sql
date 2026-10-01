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
 
 Date: 09/12/2024 15:07:41
 */
-- ----------------------------
-- Sequence structure for school_date_attribute_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_date_attribute_id_seq";

CREATE SEQUENCE "public"."school_date_attribute_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_date_attribute
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_date_attribute";

CREATE TABLE "public"."school_date_attribute" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('school_date_attribute_id_seq' :: regclass)
);

-- ----------------------------
-- Records of school_date_attribute
-- ----------------------------
INSERT INTO
    "public"."school_date_attribute"
VALUES
    (
        'Sri Lankan Calendar Holiday',
        Null,
        NULL,
        '2024-12-26 16:07:44',
        NULL,
        1
    );

INSERT INTO
    "public"."school_date_attribute"
VALUES
    (
        'Special Government Holiday',
        Null,
        NULL,
        '2024-12-26 16:07:44',
        NULL,
        2
    );

INSERT INTO
    "public"."school_date_attribute"
VALUES
    (
        'Special School Holiday',
        Null,
        NULL,
        '2024-12-26 16:07:44',
        NULL,
        3
    );

INSERT INTO
    "public"."school_date_attribute"
VALUES
    (
        'Special School Working Day',
        Null,
        NULL,
        '2024-12-26 16:07:44',
        NULL,
        4
    );

-- ----------------------------
-- Primary Key structure for table school_date_attribute
-- ----------------------------
ALTER TABLE
    "public"."school_date_attribute"
ADD
    CONSTRAINT "school_date_attribute_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_date_attribute_id_seq" OWNED BY "public"."school_date_attribute"."id";

SELECT
    setval(
        '"public"."school_date_attribute_id_seq"',
        4,
        true
    );