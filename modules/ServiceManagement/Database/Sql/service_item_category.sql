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
-- Sequence structure for service_item_category_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."service_item_category_id_seq";

CREATE SEQUENCE "public"."service_item_category_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for service_item_category
-- ----------------------------
DROP TABLE IF EXISTS "public"."service_item_category";

CREATE TABLE "public"."service_item_category" (
    "id" int8 NOT NULL DEFAULT nextval('service_item_category_id_seq' :: regclass),
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "service_item_type_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of service_item_category
-- ---------------------------- 
INSERT INTO
    "public"."service_item_category"
VALUES
    (2, 'Uniforms', 1, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (3, 'Books', 1, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (4, 'Medicine', 1, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (
        5,
        'Other Reselling Items',
        1,
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."service_item_category"
VALUES
    (6, 'Stationary', 2, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (
        7,
        'Tools & Equipment',
        3,
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."service_item_category"
VALUES
    (8, 'Cleaning Items', 4, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (
        9,
        'Vehicle Maintenance Items',
        4,
        NULL,
        NULL,
        NULL,
        NULL
    );

INSERT INTO
    "public"."service_item_category"
VALUES
    (10, 'Food & Beverage', 5, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (11, 'Medicine', 5, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (12, 'Tables & Chairs', 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."service_item_category"
VALUES
    (
        1,
        'Stationary',
        1,
        NULL,
        36,
        NULL,
        '2024-12-30 01:14:21'
    );

-- ----------------------------
-- Primary Key structure for table service_item_category
-- ----------------------------
ALTER TABLE
    "public"."service_item_category"
ADD
    CONSTRAINT "service_item_category_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."service_item_category_id_seq" OWNED BY "public"."service_item_category"."id";

SELECT
    setval(
        '"public"."service_item_category_id_seq"',
        12,
        true
    );