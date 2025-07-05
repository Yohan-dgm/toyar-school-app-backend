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
 
 Date: 09/12/2024 10:15:03
 */
-- ----------------------------
-- Sequence structure for religion_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."religion_id_seq";

CREATE SEQUENCE "public"."religion_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for religion
-- ----------------------------
DROP TABLE IF EXISTS "public"."religion";

CREATE TABLE "public"."religion" (
    "id" int8 NOT NULL DEFAULT nextval('religion_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "short_code" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of religion
-- ----------------------------
INSERT INTO
    "public"."religion"
VALUES
    (
        1,
        'Christianity',
        'CHR',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        2,
        'Islam',
        'ISL',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        3,
        'Hinduism',
        'HIN',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        4,
        'Buddhism',
        'BUD',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        5,
        'Judaism',
        'JUD',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        6,
        'Sikhism',
        'SIK',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        7,
        'Taoism',
        'TAO',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        8,
        'Shinto',
        'SHI',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."religion"
VALUES
    (
        9,
        'Zoroastrianism',
        'ZOR',
        NULL,
        NULL,
        NULL,
        NULL
    );

-- ----------------------------
-- Primary Key structure for table religion
-- ----------------------------
ALTER TABLE
    "public"."religion"
ADD
    CONSTRAINT "religion_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."religion_id_seq" OWNED BY "public"."religion"."id";

SELECT
    setval('"public"."religion_id_seq"', 9, true);