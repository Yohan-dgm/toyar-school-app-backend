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
-- Sequence structure for edu_fb_predefined_question_sc_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."edu_fb_predefined_question_sc_id_seq";

CREATE SEQUENCE "public"."edu_fb_predefined_question_sc_id_seq" INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 1 CACHE 1;

-- ----------------------------
-- Table structure for edu_fb_predefined_question_sc
-- ----------------------------
DROP TABLE IF EXISTS "public"."edu_fb_predefined_question_sc";

CREATE TABLE "public"."edu_fb_predefined_question_sc" (
    "id" int8 NOT NULL DEFAULT nextval('edu_fb_predefined_question_sc_id_seq' :: regclass),
    "question" text COLLATE "pg_catalog"."default",
    "edu_fb_category_sc_id" int8,
    "edu_fb_answer_type_id" int8,
    "is_active" boolean DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of edu_fb_predefined_question_sc (Secondary section specific questions)
-- ----------------------------
-- Subject Mastery questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (1, 'How thoroughly does the student demonstrate mastery of subject concepts?', 1, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (2, 'How effectively does the student apply subject knowledge to complex problems?', 1, 1, true, NULL, NULL, NULL, NULL);

-- Critical Thinking and Analysis questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (3, 'How well does the student analyze and evaluate information?', 2, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (4, 'How effectively does the student construct logical arguments?', 2, 1, true, NULL, NULL, NULL, NULL);

-- Research and Investigation Skills questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (5, 'How independently does the student conduct research projects?', 3, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (6, 'How well does the student use reliable sources and cite references?', 3, 1, true, NULL, NULL, NULL, NULL);

-- Communication and Presentation questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (7, 'How effectively does the student present ideas orally?', 4, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (8, 'How well does the student communicate in written form?', 4, 1, true, NULL, NULL, NULL, NULL);

-- Leadership and Initiative questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (9, 'How does the student demonstrate leadership in group settings?', 5, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (10, 'How proactively does the student take initiative in learning?', 5, 1, true, NULL, NULL, NULL, NULL);

-- Independent Learning questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (11, 'How effectively does the student manage independent study?', 6, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (12, 'How well does the student set and achieve personal learning goals?', 6, 1, true, NULL, NULL, NULL, NULL);

-- Career Preparation questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (13, 'How well does the student connect learning to career interests?', 7, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (14, 'How does the student demonstrate professional skills and work ethic?', 7, 1, true, NULL, NULL, NULL, NULL);

-- Digital Literacy questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (15, 'How effectively does the student use advanced technology tools?', 8, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (16, 'How well does the student demonstrate digital responsibility and ethics?', 8, 1, true, NULL, NULL, NULL, NULL);

-- Global Citizenship questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (17, 'How does the student show awareness of global issues?', 9, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (18, 'How well does the student appreciate diverse perspectives and cultures?', 9, 1, true, NULL, NULL, NULL, NULL);

-- Exam Preparation and Performance questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (19, 'How effectively does the student prepare for assessments?', 10, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (20, 'How well does the student perform under exam conditions?', 10, 1, true, NULL, NULL, NULL, NULL);

-- University and Career Readiness questions
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (21, 'How well prepared is the student for higher education?', 11, 1, true, NULL, NULL, NULL, NULL);
INSERT INTO "public"."edu_fb_predefined_question_sc" VALUES (22, 'How does the student demonstrate readiness for career challenges?', 11, 1, true, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table edu_fb_predefined_question_sc
-- ----------------------------
ALTER TABLE
    "public"."edu_fb_predefined_question_sc"
ADD
    CONSTRAINT "edu_fb_predefined_question_sc_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."edu_fb_predefined_question_sc_id_seq" OWNED BY "public"."edu_fb_predefined_question_sc"."id";

SELECT
    setval(
        '"public"."edu_fb_predefined_question_sc_id_seq"',
        22,
        true
    );