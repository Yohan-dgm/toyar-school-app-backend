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
-- Sequence structure for school_house_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_house_id_seq";

CREATE SEQUENCE "public"."school_house_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_house
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_house";

CREATE TABLE "public"."school_house" (
    "id" int8 NOT NULL DEFAULT nextval('school_house_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of school_house
-- ----------------------------
INSERT INTO
    "public"."school_house"
VALUES
    (1, 'Calypso', NULL, NULL);

INSERT INTO
    "public"."school_house"
VALUES
    (2, 'Eurus', NULL, NULL);

INSERT INTO
    "public"."school_house"
VALUES
    (3, 'Tellus', NULL, NULL);

INSERT INTO
    "public"."school_house"
VALUES
    (4, 'Vulcan', NULL, NULL);

-- ----------------------------
-- Primary Key structure for table school_house
-- ----------------------------
ALTER TABLE
    "public"."school_house"
ADD
    CONSTRAINT "school_house_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_house_id_seq" OWNED BY "public"."school_house"."id";

SELECT
    setval(
        '"public"."school_house_id_seq"',
        4,
        true
    );