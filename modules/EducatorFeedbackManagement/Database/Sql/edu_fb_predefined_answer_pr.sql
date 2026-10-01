/*
 Navicat Premium Data Transfer

 Source Server         : postgres_local
 Source Server Type    : PostgreSQL
 Source Server Version : 160000 (160000)
 Source Host           : localhost:5432
 Source Catalog        : sms_backend_v1
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 160000 (160000)
 File Encoding         : 65001

 Date: 06/10/2025 16:15:00
 */
-- ----------------------------
-- Sequence structure for edu_fb_predefined_answer_pr_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_predefined_answer_pr_id_seq";

CREATE SEQUENCE "public"."edu_fb_predefined_answer_pr_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_predefined_answer_pr
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_predefined_answer_pr";

CREATE TABLE "public"."edu_fb_predefined_answer_pr" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_predefined_answer_pr_id_seq' :: regclass),
    "edu_fb_predefined_question_pr_id" int8,
    "predefined_answer" varchar(255) COLLATE "pg_catalog"."default",
    "marks" int8 DEFAULT 0,
    "is_active" int8,
    "predefined_answer_weight" int8 DEFAULT 0,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_predefined_answer_pr (Primary section specific answers)
-- ----------------------------
-- Academic Performance answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (1, 1, 'Always On Time', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (2, 1, 'Usually On Time', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (3, 1, 'Sometimes Late', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (4, 1, 'Often Late', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (5, 1, 'Rarely Submits', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (6, 2, 'Excellent Understanding', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (7, 2, 'Good Understanding', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (8, 2, 'Satisfactory', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (9, 2, 'Needs Improvement', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (10, 2, 'Requires Support', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Reading and Writing Skills answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (11, 3, 'Fluent Reader', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (12, 3, 'Good Reader', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (13, 3, 'Average Reader', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (14, 3, 'Struggling Reader', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (15, 3, 'Needs Reading Support', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (16, 4, 'Excellent Writer', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (17, 4, 'Good Writer', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (18, 4, 'Average Writer', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (19, 4, 'Developing Writer', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (20, 4, 'Needs Writing Support', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Mathematical Skills answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (21, 5, 'Excellent Problem Solver', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (22, 5, 'Good Problem Solver', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (23, 5, 'Average Problem Solver', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (24, 5, 'Struggles with Problems', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (25, 5, 'Needs Math Support', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (26, 6, 'Always Applies Concepts', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (27, 6, 'Usually Applies Concepts', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (28, 6, 'Sometimes Applies', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (29, 6, 'Rarely Applies', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (30, 6, 'Cannot Apply', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Social Skills and Teamwork answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (31, 9, 'Excellent Team Player', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (32, 9, 'Good Team Player', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (33, 9, 'Average Cooperation', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (34, 9, 'Needs Encouragement', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (35, 9, 'Prefers Individual Work', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (36, 10, 'Always Respectful', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (37, 10, 'Usually Respectful', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (38, 10, 'Sometimes Respectful', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (39, 10, 'Needs Reminders', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (40, 10, 'Requires Guidance', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Study Habits and Organization answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (41, 15, 'Extremely Organized', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (42, 15, 'Well Organized', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (43, 15, 'Moderately Organized', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (44, 15, 'Poor Organization', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (45, 15, 'Very Disorganized', 1, 1, 1, NULL, NULL, NULL, NULL);

INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (46, 16, 'Excellent Time Management', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (47, 16, 'Good Time Management', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (48, 16, 'Average Time Management', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (49, 16, 'Poor Time Management', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (50, 16, 'Cannot Manage Time', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Character Development answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (51, 17, 'Always Honest', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (52, 17, 'Usually Honest', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (53, 17, 'Sometimes Honest', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (54, 17, 'Needs Guidance', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (55, 17, 'Requires Support', 1, 1, 1, NULL, NULL, NULL, NULL);

-- Technology Skills answers
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (56, 19, 'Advanced User', 5, 1, 5, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (57, 19, 'Proficient User', 4, 1, 4, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (58, 19, 'Basic User', 3, 1, 3, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (59, 19, 'Needs Assistance', 2, 1, 2, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_answer_pr" VALUES (60, 19, 'Requires Training', 1, 1, 1, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_predefined_answer_pr
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_predefined_answer_pr"
ADD
    CONSTRAINT "edu_fb_predefined_answer_pr_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_predefined_answer_pr_id_seq" OWNED BY "public"."edu_fb_predefined_answer_pr"."id";

SELECT
    setval(
        '"public"."edu_fb_predefined_answer_pr_id_seq"',
        60,
        true
    );