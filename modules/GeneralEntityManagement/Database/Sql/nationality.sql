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
-- Sequence structure for nationality_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."nationality_id_seq";

CREATE SEQUENCE "public"."nationality_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for nationality
-- ----------------------------
DROP TABLE IF EXISTS "public"."nationality";

CREATE TABLE "public"."nationality" (
    "id" int8 NOT NULL DEFAULT nextval('nationality_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "short_code" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of nationality
-- ----------------------------
INSERT INTO
    "public"."nationality"
VALUES
    (
        1,
        'Afghan',
        'AF',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        2,
        'Albanian',
        'AL',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        3,
        'American',
        'US',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        4,
        'Argentinian',
        'AR',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        5,
        'Australian',
        'AU',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        6,
        'Bangladeshi',
        'BD',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        7,
        'British',
        'GB',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        8,
        'Canadian',
        'CA',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        9,
        'Chinese',
        'CN',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        10,
        'Egyptian',
        'EG',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        11,
        'French',
        'FR',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        12,
        'German',
        'DE',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        13,
        'Indian',
        'IN',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        14,
        'Italian',
        'IT',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        15,
        'Japanese',
        'JP',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        16,
        'Pakistani',
        'PK',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        17,
        'Russian',
        'RU',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        18,
        'South African',
        'ZA',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        19,
        'Sri Lankan',
        'LK',
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."nationality"
VALUES
    (
        20,
        'Turkish',
        'TR',
        NULL,
        NULL,
        NULL,
        NULL
    );

-- ----------------------------
-- Primary Key structure for table nationality
-- ----------------------------
ALTER TABLE
    "public"."nationality"
ADD
    CONSTRAINT "nationality_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."nationality_id_seq" OWNED BY "public"."nationality"."id";

SELECT
    setval('"public"."nationality_id_seq"', 20, true);