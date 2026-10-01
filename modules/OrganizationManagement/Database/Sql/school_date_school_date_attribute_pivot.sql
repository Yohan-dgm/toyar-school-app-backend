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
-- Sequence structure for school_date_school_date_attribute_pivot_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_date_school_date_attribute_pivot_id_seq";

CREATE SEQUENCE "public"."school_date_school_date_attribute_pivot_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_date_school_date_attribute_pivot
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_date_school_date_attribute_pivot";

CREATE TABLE "public"."school_date_school_date_attribute_pivot" (
    "school_date_id" int8,
    "school_date_attribute_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval(
        'school_date_school_date_attribute_pivot_id_seq' :: regclass
    )
);

-- ----------------------------
-- Records of school_date_school_date_attribute_pivot
-- ----------------------------
INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (16, 2, NULL, NULL, NULL, NULL, 1);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (17, 2, NULL, NULL, NULL, NULL, 2);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (47, 2, NULL, NULL, NULL, NULL, 3);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (61, 2, NULL, NULL, NULL, NULL, 4);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (76, 2, NULL, NULL, NULL, NULL, 5);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (105, 2, NULL, NULL, NULL, NULL, 6);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (116, 2, NULL, NULL, NULL, NULL, 7);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (135, 2, NULL, NULL, NULL, NULL, 8);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (136, 2, NULL, NULL, NULL, NULL, 9);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (157, 2, NULL, NULL, NULL, NULL, 10);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (165, 2, NULL, NULL, NULL, NULL, 11);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (179, 2, NULL, NULL, NULL, NULL, 12);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (194, 2, NULL, NULL, NULL, NULL, 13);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (212, 2, NULL, NULL, NULL, NULL, 14);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (224, 2, NULL, NULL, NULL, NULL, 15);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (225, 2, NULL, NULL, NULL, NULL, 16);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (226, 2, NULL, NULL, NULL, NULL, 17);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (227, 2, NULL, NULL, NULL, NULL, 18);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (230, 2, NULL, NULL, NULL, NULL, 19);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (243, 2, NULL, NULL, NULL, NULL, 20);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (254, 2, NULL, NULL, NULL, NULL, 21);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (255, 2, NULL, NULL, NULL, NULL, 22);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (280, 2, NULL, NULL, NULL, NULL, 23);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (283, 2, NULL, NULL, NULL, NULL, 24);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (313, 2, NULL, NULL, NULL, NULL, 25);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (342, 2, NULL, NULL, NULL, NULL, 26);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (1, 1, NULL, NULL, NULL, NULL, 27);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (8, 1, NULL, NULL, NULL, NULL, 28);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (15, 1, NULL, NULL, NULL, NULL, 29);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (22, 1, NULL, NULL, NULL, NULL, 30);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (29, 1, NULL, NULL, NULL, NULL, 31);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (36, 1, NULL, NULL, NULL, NULL, 32);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (43, 1, NULL, NULL, NULL, NULL, 33);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (50, 1, NULL, NULL, NULL, NULL, 34);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (57, 1, NULL, NULL, NULL, NULL, 35);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (64, 1, NULL, NULL, NULL, NULL, 36);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (71, 1, NULL, NULL, NULL, NULL, 37);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (78, 1, NULL, NULL, NULL, NULL, 38);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (85, 1, NULL, NULL, NULL, NULL, 39);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (92, 1, NULL, NULL, NULL, NULL, 40);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (99, 1, NULL, NULL, NULL, NULL, 41);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (106, 1, NULL, NULL, NULL, NULL, 42);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (113, 1, NULL, NULL, NULL, NULL, 43);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (120, 1, NULL, NULL, NULL, NULL, 44);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (127, 1, NULL, NULL, NULL, NULL, 45);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (134, 1, NULL, NULL, NULL, NULL, 46);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (141, 1, NULL, NULL, NULL, NULL, 47);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (148, 1, NULL, NULL, NULL, NULL, 48);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (155, 1, NULL, NULL, NULL, NULL, 49);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (162, 1, NULL, NULL, NULL, NULL, 50);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (169, 1, NULL, NULL, NULL, NULL, 51);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (176, 1, NULL, NULL, NULL, NULL, 52);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (183, 1, NULL, NULL, NULL, NULL, 53);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (190, 1, NULL, NULL, NULL, NULL, 54);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (197, 1, NULL, NULL, NULL, NULL, 55);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (204, 1, NULL, NULL, NULL, NULL, 56);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (211, 1, NULL, NULL, NULL, NULL, 57);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (218, 1, NULL, NULL, NULL, NULL, 58);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (225, 1, NULL, NULL, NULL, NULL, 59);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (232, 1, NULL, NULL, NULL, NULL, 60);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (239, 1, NULL, NULL, NULL, NULL, 61);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (246, 1, NULL, NULL, NULL, NULL, 62);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (253, 1, NULL, NULL, NULL, NULL, 63);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (260, 1, NULL, NULL, NULL, NULL, 64);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (267, 1, NULL, NULL, NULL, NULL, 65);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (274, 1, NULL, NULL, NULL, NULL, 66);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (281, 1, NULL, NULL, NULL, NULL, 67);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (288, 1, NULL, NULL, NULL, NULL, 68);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (295, 1, NULL, NULL, NULL, NULL, 69);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (302, 1, NULL, NULL, NULL, NULL, 70);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (309, 1, NULL, NULL, NULL, NULL, 71);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (316, 1, NULL, NULL, NULL, NULL, 72);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (323, 1, NULL, NULL, NULL, NULL, 73);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (330, 1, NULL, NULL, NULL, NULL, 74);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (337, 1, NULL, NULL, NULL, NULL, 75);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (344, 1, NULL, NULL, NULL, NULL, 76);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (351, 1, NULL, NULL, NULL, NULL, 77);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (358, 1, NULL, NULL, NULL, NULL, 78);

INSERT INTO
    "public"."school_date_school_date_attribute_pivot"
VALUES
    (365, 1, NULL, NULL, NULL, NULL, 79);

-- ----------------------------
-- Primary Key structure for table school_date_school_date_attribute_pivot
-- ----------------------------
ALTER TABLE
    "public"."school_date_school_date_attribute_pivot"
ADD
    CONSTRAINT "school_date_school_date_attribute_pivot_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_date_school_date_attribute_pivot_id_seq" OWNED BY "public"."school_date_school_date_attribute_pivot"."id";

SELECT
    setval(
        '"public"."school_date_school_date_attribute_pivot_id_seq"',
        79,
        true
    );