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
 
 Date: 09/12/2024 09:41:15
 */
-- ----------------------------
-- Sequence structure for subject_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."subject_id_seq";

CREATE SEQUENCE "public"."subject_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for subject
-- ----------------------------
DROP TABLE IF EXISTS "public"."subject";

CREATE TABLE "public"."subject" (
    "name" varchar(255) COLLATE "pg_catalog"."default",
    "subject_code" varchar(255) COLLATE "pg_catalog"."default",
    "is_elective_subject" bool,
    "program_id" int8,
    "subject_type_id" int8,
    "stream_id" int8,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "id" int8 NOT NULL DEFAULT nextval('subject_id_seq' :: regclass),
);

-- ----------------------------
-- Records of subject
-- ----------------------------
INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G1-SI',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        1
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Primary English',
        'G1-PE',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        2
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Global English',
        'G1-GE',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        3
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G1-RE',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        4
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G1-MA',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        5
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Science',
        'G1-SC',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        6
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts & Design',
        'G1-AD',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        7
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G1-MU',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        8
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G1-DA',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        9
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Wellbeing',
        'G1-WE',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        10
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G1-PH',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        11
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing and Digital Literacy',
        'G1-CD',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        12
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Innovation',
        'G1-IN',
        'f',
        1,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        13
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Innovation',
        'G2-IN',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        26
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G3-SI',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        27
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Primary English',
        'G3-PE',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        28
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Global English',
        'G3-GE',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        29
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G3-RE',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        30
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G3-MA',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        31
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Science',
        'G3-SC',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        32
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts & Design',
        'G3-AD',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        33
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G3-MU',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        34
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G3-DA',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        35
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Wellbeing',
        'G3-WE',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        36
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G3-PH',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        37
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing and Digital Literacy',
        'G3-CD',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        38
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Innovation',
        'G3-IN',
        'f',
        3,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        39
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G4-MA',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        40
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G4-SI',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        41
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Primary English',
        'G4-PE',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        42
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Global English',
        'G4-GE',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        43
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G4-RE',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        44
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Science',
        'G4-SC',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        45
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts & Design',
        'G4-AD',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        46
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G4-MU',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        47
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G4-DA',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        48
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Wellbeing',
        'G4-WE',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        49
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G4-PH',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        50
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing and Digital Literacy',
        'G4-CD',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        51
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Innovation',
        'G4-IN',
        'f',
        4,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        52
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G5-SI',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        53
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Primary English',
        'G5-PE',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        54
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Global English',
        'G5-GE',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        55
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G5-RE',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        56
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G5-MA',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        57
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Science',
        'G5-SC',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        58
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G7-RE',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        59
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G5-MU',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        60
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G5-DA',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        61
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G8-SI',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        91
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'English and Literature',
        'G8-EL',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        92
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G8-RE',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        93
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G8-MA',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        94
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physics',
        'G8-PS',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        95
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Chemistry',
        'G8-CH',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        96
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Biology',
        'G8-BI',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        97
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Wellbeing',
        'G5-WE',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        62
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G5-PH',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        63
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing and Digital Literacy',
        'G5-CD',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        64
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Innovation',
        'G5-IN',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        65
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G6-SI',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        66
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'English and Literature',
        'G6-EL',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        67
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G6-RE',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        68
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G6-MA',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        69
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Science',
        'G6-SC',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        70
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G6-PH',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        71
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing',
        'G6-CO',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        72
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Digital Literacy',
        'G6-DL',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        73
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts and Design',
        'G5-AD',
        'f',
        5,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        77
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G7-SI',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        78
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'English and Literature',
        'G7-EL',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        79
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G7-MA',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        80
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physics',
        'G7-PS',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        81
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Chemistry',
        'G7-CH',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        82
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Biology',
        'G7-BI',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        83
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G7-PH',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        84
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing',
        'G7-CO',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        85
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Digital Literacy',
        'G7-DL',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        86
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G9-SI',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        90
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Global English',
        'G2-GE',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        16
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Religion',
        'G2-RE',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        17
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G2-MA',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        18
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Science',
        'G2-SC',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        19
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts & Design',
        'G2-AD',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        20
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G2-MU',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        21
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G2-DA',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        22
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G2-PH',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        24
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing and Digital Literacy',
        'G2-CD',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        25
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G6-DA',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        74
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Primary English',
        'G2-PE',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        15
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G6-MU',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        75
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts and Design',
        'G6-AD',
        'f',
        6,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        76
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G7-DA',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        87
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G7-MU',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        88
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts and Design',
        'G7-AD',
        'f',
        7,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        89
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physical Education',
        'G8-PH',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        98
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing',
        'G8-CO',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        99
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Digital Literacy',
        'G8-DL',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        100
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'English',
        'G9-EN',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        104
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G9-MA',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        105
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physics',
        'G9-PS',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        106
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Chemistry',
        'G9-CH',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        107
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Biology',
        'G9-BI',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        108
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing',
        'G9-CO',
        'f',
        9,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        109
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G10-SI',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        110
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'English',
        'G10-EN',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        111
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G10-MA',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        112
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physics',
        'G10-PS',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        113
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Chemistry',
        'G10-CH',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        114
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Biology',
        'G10-BI',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        115
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Computing',
        'G10-CO',
        'f',
        10,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        116
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physics',
        'G11-PS',
        'f',
        11,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        117
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Chemistry',
        'G11-CH',
        'f',
        11,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        118
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Physics',
        'G12-PS',
        'f',
        12,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        121
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Chemistry',
        'G12-CH',
        'f',
        12,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        122
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Sinhala',
        'G2-SI',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        14
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Wellbeing',
        'G2-WE',
        'f',
        2,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        23
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Dancing',
        'G8-DA',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        101
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Music',
        'G8-MU',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        102
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Arts and Design',
        'G8-AD',
        'f',
        8,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        103
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G11-MA',
        'f',
        11,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        119
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Biology',
        'G11-BI',
        'f',
        11,
        1,
        1,
        NULL,
        NULL,
        NULL,
        NULL,
        120
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Mathematics',
        'G12-MA',
        'f',
        12,
        2,
        2,
        NULL,
        NULL,
        NULL,
        NULL,
        123
    );

INSERT INTO
    "public"."subject"
VALUES
    (
        'Biology',
        'G12-BI',
        'f',
        12,
        2,
        3,
        NULL,
        NULL,
        NULL,
        NULL,
        124
    );

-- ----------------------------
-- Primary Key structure for table subject
-- ----------------------------
ALTER TABLE
    "public"."subject"
ADD
    CONSTRAINT "subject_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."subject_id_seq" OWNED BY "public"."subject"."id";

SELECT
    setval('"public"."subject_id_seq"', 124, true);