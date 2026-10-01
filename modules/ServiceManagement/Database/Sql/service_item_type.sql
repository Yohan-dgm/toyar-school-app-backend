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
-- Sequence structure for service_item_type_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."service_item_type_id_seq";

CREATE SEQUENCE "public"."service_item_type_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for service_item_type
-- ----------------------------
DROP TABLE IF EXISTS "public"."service_item_type";

CREATE TABLE "public"."service_item_type" (
    "id" int8 NOT NULL DEFAULT nextval('service_item_type_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "sequential_order" int4
);

-- ----------------------------
-- Records of service_item_type
-- ---------------------------- 
INSERT INTO
    "public"."service_item_type"
VALUES
    (1, 'Material Item', NULL, NULL, NULL, NULL, 1);

INSERT INTO
    "public"."service_item_type"
VALUES
    (2, 'Consumable Item', NULL, NULL, NULL, NULL, 2);

INSERT INTO
    "public"."service_item_type"
VALUES
    (3, 'Indirect Item', NULL, NULL, NULL, NULL, 3);

INSERT INTO
    "public"."service_item_type"
VALUES
    (4, 'Maintenance Item', NULL, NULL, NULL, NULL, 4);

INSERT INTO
    "public"."service_item_type"
VALUES
    (
        5,
        'Staff Welfare Item',
        NULL,
        NULL,
        NULL,
        NULL,
        5
    );

-- ----------------------------
-- Primary Key structure for table service_item_type
-- ----------------------------
ALTER TABLE
    "public"."service_item_type"
ADD
    CONSTRAINT "service_item_type_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."service_item_type_id_seq" OWNED BY "public"."service_item_type"."id";

SELECT
    setval(
        '"public"."service_item_type_id_seq"',
        5,
        true
    );