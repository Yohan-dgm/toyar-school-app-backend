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

 Date: 06/10/2025 16:00:00
 */
-- ----------------------------
-- Sequence structure for edu_fb_predefined_question_pr_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_predefined_question_pr_id_seq";

CREATE SEQUENCE "public"."edu_fb_predefined_question_pr_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_predefined_question_pr
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_predefined_question_pr";

CREATE TABLE "public"."edu_fb_predefined_question_pr" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_predefined_question_pr_id_seq' :: regclass),
    "question" text COLLATE "pg_catalog"."default",
    "edu_fb_category_pr_id" int8,
    "edu_fb_answer_type_id" int8,
    "is_active" boolean DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_predefined_question_pr (Primary section specific questions)
-- ----------------------------
-- Academic Performance questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (1, 'How consistently does the student complete assignments on time?', 1, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (2, 'How well does the student demonstrate understanding of core subjects?', 1, 1, true, NULL, NULL, NULL, NULL);

-- Reading and Writing Skills questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (3, 'How fluently does the student read age-appropriate texts?', 2, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (4, 'How effectively does the student express ideas in writing?', 2, 1, true, NULL, NULL, NULL, NULL);

-- Mathematical Skills questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (5, 'How well does the student solve mathematical problems?', 3, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (6, 'How does the student apply mathematical concepts to real situations?', 3, 1, true, NULL, NULL, NULL, NULL);

-- Scientific Thinking questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (7, 'How does the student approach scientific investigations?', 4, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (8, 'How well does the student make observations and predictions?', 4, 1, true, NULL, NULL, NULL, NULL);

-- Social Skills and Teamwork questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (9, 'How effectively does the student work in group activities?', 5, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (10, 'How does the student show respect and kindness to others?', 5, 1, true, NULL, NULL, NULL, NULL);

-- Creative and Artistic Skills questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (11, 'How creatively does the student approach art projects?', 6, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (12, 'How does the student express creativity in various subjects?', 6, 1, true, NULL, NULL, NULL, NULL);

-- Physical Education and Sports questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (13, 'How actively does the student participate in physical activities?', 7, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (14, 'How does the student demonstrate sportsmanship and fair play?', 7, 1, true, NULL, NULL, NULL, NULL);

-- Study Habits and Organization questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (15, 'How well does the student organize materials and workspace?', 8, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (16, 'How effectively does the student manage time and tasks?', 8, 1, true, NULL, NULL, NULL, NULL);

-- Character Development questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (17, 'How does the student demonstrate honesty and integrity?', 9, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (18, 'How well does the student show responsibility for actions?', 9, 1, true, NULL, NULL, NULL, NULL);

-- Technology Skills questions
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (19, 'How effectively does the student use technology for learning?', 10, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_pr" VALUES (20, 'How does the student demonstrate digital citizenship?', 10, 1, true, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_predefined_question_pr
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_predefined_question_pr"
ADD
    CONSTRAINT "edu_fb_predefined_question_pr_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_predefined_question_pr_id_seq" OWNED BY "public"."edu_fb_predefined_question_pr"."id";

SELECT
    setval(
        '"public"."edu_fb_predefined_question_pr_id_seq"',
        20,
        true
    );