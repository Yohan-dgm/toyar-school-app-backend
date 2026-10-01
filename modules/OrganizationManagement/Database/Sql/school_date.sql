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
-- Sequence structure for school_date_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."school_date_id_seq";

CREATE SEQUENCE "public"."school_date_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for school_date
-- ----------------------------
DROP TABLE IF EXISTS "public"."school_date";

CREATE TABLE "public"."school_date" (
    "school_year_id" int8,
    "date" date,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('school_date_id_seq' :: regclass),
    "working_day_start_time" time(6),
    "working_day_end_time" time(6)
);

-- ----------------------------
-- Records of school_date
-- ----------------------------
INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        1,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        3,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        4,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        5,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        6,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        9,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        11,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        12,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        13,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        15,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        16,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        17,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        19,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        20,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        21,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        22,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        24,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        25,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        26,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        28,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        29,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        30,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        31,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        33,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        34,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        35,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        36,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        38,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        39,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        40,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        42,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        43,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        44,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        45,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        47,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        48,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        49,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        51,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        52,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        53,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        54,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        56,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        57,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        58,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        59,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        61,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        62,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        63,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        65,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        66,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        67,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        68,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        70,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        71,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        72,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        74,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        75,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        76,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        77,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        79,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        80,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        81,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        82,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        84,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        85,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        86,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        88,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        89,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        90,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        91,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        93,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        94,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        95,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        97,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        98,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        99,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        100,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        102,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        103,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        104,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        105,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        107,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        108,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        110,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        112,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        113,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        114,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        115,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        117,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        118,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        119,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        120,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        122,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        123,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        124,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        126,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        127,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        128,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        129,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        131,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        132,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        133,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        135,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        136,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        137,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        138,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        140,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        141,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        142,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        143,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        145,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        146,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        147,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        149,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        150,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        151,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        152,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        154,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        155,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        156,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        158,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        159,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        160,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        161,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        163,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        164,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        165,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        166,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        168,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        169,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        170,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        172,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        173,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        174,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        175,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        177,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        178,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        179,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        181,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        182,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        183,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        184,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        186,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        187,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        188,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        189,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        191,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        192,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        193,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        195,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        196,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        197,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        198,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        200,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        201,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        202,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        204,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        205,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        206,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        207,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        209,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        210,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        211,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        212,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        214,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        215,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        217,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        219,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        220,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        221,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        222,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        224,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        225,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        226,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        227,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        229,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        230,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        231,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        233,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        234,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        235,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        236,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        238,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        239,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        240,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        242,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        243,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        244,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        245,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        247,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        248,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        249,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        250,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        252,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        253,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        254,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        256,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        257,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        258,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        259,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        261,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        262,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        263,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        265,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        266,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        267,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        268,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        270,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        271,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        272,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        273,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        275,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        276,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        277,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        279,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        280,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        281,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        282,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        284,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        285,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        286,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        288,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        289,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        290,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        291,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        293,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        294,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        295,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        296,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        298,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        299,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        300,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        302,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        303,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        304,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        305,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        307,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        308,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        309,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        311,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        312,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        313,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        314,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        316,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        317,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        318,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        319,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        321,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        322,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        2,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        7,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        10,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        14,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        18,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        23,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        27,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        32,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        37,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        41,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        46,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        50,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        55,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-10-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        60,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        64,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        69,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        73,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        78,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        83,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-11-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        87,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        92,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        96,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        101,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        106,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        109,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        111,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        116,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-12-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        121,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        125,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        130,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        134,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        139,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        144,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        148,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-01-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        153,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        157,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        162,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        167,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        171,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        176,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-02-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        180,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        185,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        190,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        194,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        199,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        203,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-03-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        208,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        213,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        216,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        218,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        223,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        228,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        232,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        325,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        326,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        327,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        329,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        330,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        331,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        332,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        334,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        335,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-02',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        336,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        337,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        339,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-06',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        340,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        341,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        343,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        344,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-11',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        345,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        346,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        348,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-15',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        349,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-16',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        350,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        352,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        353,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        354,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        355,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-23',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        357,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        358,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        359,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-26',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        360,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        362,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        363,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        364,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        237,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-04-29',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        241,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        246,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-09',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        251,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        255,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-18',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        260,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        264,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-05-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        269,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-01',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        274,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-05',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        278,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-10',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        283,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-14',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        287,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-19',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        292,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-24',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        297,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-06-28',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        301,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-03',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        306,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-07',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        310,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-12',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        315,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        320,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-20',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        323,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-21',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        324,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-25',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        328,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-07-30',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        333,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-04',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        338,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        342,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-13',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        347,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-17',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        351,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-22',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        356,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-27',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        361,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2024-09-08',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        8,
        '07:30:00',
        '13:30:00'
    );

INSERT INTO
    "public"."school_date"
VALUES
    (
        1,
        '2025-08-31',
        NULL,
        NULL,
        '2024-12-26 21:19:00',
        '2024-12-26 21:19:00',
        365,
        '07:30:00',
        '13:30:00'
    );

-- ----------------------------
-- Primary Key structure for table school_date
-- ----------------------------
ALTER TABLE
    "public"."school_date"
ADD
    CONSTRAINT "school_date_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."school_date_id_seq" OWNED BY "public"."school_date"."id";

SELECT
    setval('"public"."school_date_id_seq"', 365, true);