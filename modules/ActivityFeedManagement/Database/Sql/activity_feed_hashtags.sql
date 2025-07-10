-- ----------------------------
-- Sequence structure for activity_feed_hashtags_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."activity_feed_hashtags_id_seq";

CREATE SEQUENCE "public"."activity_feed_hashtags_id_seq"
    INCREMENT 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    START 1
    CACHE 1;

-- ----------------------------
-- Table structure for activity_feed_hashtags
-- ----------------------------
DROP TABLE IF EXISTS "public"."activity_feed_hashtags";

CREATE TABLE "public"."activity_feed_hashtags" (
    "id" int8 NOT NULL DEFAULT nextval('activity_feed_hashtags_id_seq' :: regclass),
    "post_id" int8 NOT NULL,
    "hashtag" varchar(100) COLLATE "pg_catalog"."default" NOT NULL,
    "created_at" timestamp(0),
    "updated_at" timestamp(0)
);

-- ----------------------------
-- Records of activity_feed_hashtags
-- ----------------------------
INSERT INTO "public"."activity_feed_hashtags" VALUES
(1, 1, 'NewYear', '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
(2, 1, 'Welcome', '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
(3, 1, 'Academic2024', '2024-01-15 09:00:00', '2024-01-15 09:00:00'),
(4, 2, 'SportsDay', '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
(5, 2, 'Competition', '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
(6, 2, 'Fun', '2024-01-20 10:30:00', '2024-01-20 10:30:00'),
(7, 3, 'Science', '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
(8, 3, 'Laboratory', '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
(9, 3, 'Education', '2024-01-25 14:15:00', '2024-01-25 14:15:00'),
(10, 4, 'Mathematics', '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
(11, 4, 'Achievement', '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
(12, 4, 'Pride', '2024-02-01 11:45:00', '2024-02-01 11:45:00'),
(13, 5, 'Health', '2024-02-05 08:30:00', '2024-02-05 08:30:00'),
(14, 5, 'Safety', '2024-02-05 08:30:00', '2024-02-05 08:30:00'),
(15, 5, 'Guidelines', '2024-02-05 08:30:00', '2024-02-05 08:30:00');

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."activity_feed_hashtags_id_seq" OWNED BY "public"."activity_feed_hashtags"."id";

-- ----------------------------
-- Primary Key structure for table activity_feed_hashtags
-- ----------------------------
ALTER TABLE "public"."activity_feed_hashtags" ADD CONSTRAINT "activity_feed_hashtags_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes for table activity_feed_hashtags
-- ----------------------------
CREATE INDEX "idx_activity_feed_hashtags_post_id" ON "public"."activity_feed_hashtags" USING btree ("post_id");
CREATE INDEX "idx_activity_feed_hashtags_hashtag" ON "public"."activity_feed_hashtags" USING btree ("hashtag");

-- ----------------------------
-- Foreign Keys structure for table activity_feed_hashtags
-- ----------------------------
ALTER TABLE "public"."activity_feed_hashtags" ADD CONSTRAINT "fk_activity_feed_hashtags_post_id" FOREIGN KEY ("post_id") REFERENCES "public"."activity_feed_posts" ("id") ON DELETE CASCADE ON UPDATE NO ACTION;
