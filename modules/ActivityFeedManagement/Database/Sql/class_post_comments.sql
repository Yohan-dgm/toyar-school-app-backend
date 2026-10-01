/*
 Class Post Comments Table - Comments for class posts

 Date: 23/09/2026
*/

-- ----------------------------
-- Sequence structure for class_post_comments_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."class_post_comments_id_seq";

CREATE SEQUENCE "public"."class_post_comments_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for class_post_comments
-- ----------------------------
DROP TABLE IF EXISTS "public"."class_post_comments";

CREATE TABLE "public"."class_post_comments" (
    "id" int8 NOT NULL DEFAULT nextval('class_post_comments_id_seq'::regclass),
    "post_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "content" text COLLATE "pg_catalog"."default" NOT NULL,
    "is_active" bool DEFAULT true,
    "created_by" int8,
    "updated_by" int8,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table class_post_comments
-- ----------------------------
ALTER TABLE "public"."class_post_comments"
ADD CONSTRAINT "class_post_comments_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."class_post_comments_id_seq"
OWNED BY "public"."class_post_comments"."id";

SELECT setval('"public"."class_post_comments_id_seq"', 1, false);

-- ----------------------------
-- Indexes for table class_post_comments
-- ----------------------------
CREATE INDEX "idx_class_post_comments_post_id" ON "public"."class_post_comments" USING btree ("post_id");
CREATE INDEX "idx_class_post_comments_user_id" ON "public"."class_post_comments" USING btree ("user_id");
CREATE INDEX "idx_class_post_comments_created_at" ON "public"."class_post_comments" USING btree ("created_at" DESC);
