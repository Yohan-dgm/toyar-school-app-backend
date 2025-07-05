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
-- Sequence structure for unit_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."unit_id_seq";

CREATE SEQUENCE "public"."unit_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for unit
-- ----------------------------
DROP TABLE IF EXISTS "public"."unit";

CREATE TABLE "public"."unit" (
    "id" int8 NOT NULL DEFAULT nextval('unit_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO
    "public"."unit"
VALUES
    (1, 'Numbers', NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."unit"
VALUES
    (2, 'Millimeters', NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."unit"
VALUES
    (3, 'Meters', NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."unit"
VALUES
    (4, 'Grams', NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."unit"
VALUES
    (5, 'Kilograms', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table unit
-- ----------------------------
ALTER TABLE
    "public"."unit"
ADD
    CONSTRAINT "unit_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."unit_id_seq" OWNED BY "public"."unit"."id";

SELECT
    setval(
        '"public"."unit_id_seq"',
        10,
        true
    );