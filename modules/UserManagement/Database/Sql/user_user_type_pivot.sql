/*
 Navicat Premium Data Transfer
 
 Source Server         : postgresql_localhost_root
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_development_v5
 Source Schema         : public
 
 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001
 
 Date: 19/12/2024 10:51:11
 */
-- ----------------------------
-- Sequence structure for user_user_type_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."user_user_type_pivot_id_seq";

CREATE SEQUENCE "public"."user_user_type_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for user_user_type_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."user_user_type_pivot";

CREATE TABLE "public"."user_user_type_pivot" (
    "id" int8 NOT NULL DEFAULT nextval('user_user_type_pivot_id_seq' :: regclass),
    "user_id" int8 NOT NULL,
    "user_type_id" int8 NOT NULL,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of user_user_type_pivot
-- ----------------------------
INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (1, 9, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (2, 10, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (3, 12, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (4, 2, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (5, 3, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (6, 4, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (7, 5, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (8, 17, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (9, 1, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (10, 6, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (11, 7, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (12, 8, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (13, 16, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (14, 15, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (15, 14, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (16, 13, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (17, 18, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (18, 19, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (19, 20, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (20, 21, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (21, 22, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (22, 23, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (23, 24, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (24, 25, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (25, 26, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (26, 27, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (27, 28, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (28, 29, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (29, 30, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (30, 31, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (31, 32, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (32, 33, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (33, 11, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (34, 34, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (35, 35, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (36, 36, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (37, 38, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (38, 39, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (39, 13, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (40, 35, 3, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (41, 37, 5, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (42, 40, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (43, 41, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (44, 42, 6, NULL, NULL, NULL, NULL);

INSERT INTO
    "public"."user_user_type_pivot"
VALUES
    (45, 43, 6, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table user_user_type_pivot
-- ----------------------------
ALTER TABLE
    "public"."user_user_type_pivot"
ADD
    CONSTRAINT "user_user_type_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."user_user_type_pivot_id_seq" OWNED BY "public"."user_user_type_pivot"."id";

SELECT
    setval(
        '"public"."user_user_type_pivot_id_seq"',
        45,
        true
    );