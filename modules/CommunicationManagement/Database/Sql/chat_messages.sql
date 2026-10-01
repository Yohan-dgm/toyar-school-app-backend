-- ----------------------------
-- Sequence structure for chat_messages_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."chat_messages_id_seq";

CREATE SEQUENCE "public"."chat_messages_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for chat_messages
-- ----------------------------
DROP TABLE IF EXISTS "public"."chat_messages";

CREATE TABLE "public"."chat_messages" (
    "id" int8 NOT NULL DEFAULT nextval('chat_messages_id_seq'::regclass),
    "chat_group_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "type" varchar(20) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'text',
    "content" text COLLATE "pg_catalog"."default",
    "attachment_url" varchar(500) COLLATE "pg_catalog"."default",
    "metadata" jsonb,
    "is_read" bool DEFAULT false,
    "read_at" timestamp(0),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deleted_at" timestamp(0)
);

-- ----------------------------
-- Primary Key structure for table chat_messages
-- ----------------------------
ALTER TABLE "public"."chat_messages" 
ADD CONSTRAINT "chat_messages_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Check constraints
-- ----------------------------
ALTER TABLE "public"."chat_messages" 
ADD CONSTRAINT "chat_messages_type_check" 
CHECK (type IN ('text', 'image', 'file', 'system'));

-- ----------------------------
-- Foreign Key constraints
-- ----------------------------
ALTER TABLE "public"."chat_messages" 
ADD CONSTRAINT "chat_messages_chat_group_id_fkey" 
FOREIGN KEY ("chat_group_id") REFERENCES "public"."chat_groups" ("id") ON DELETE CASCADE;

ALTER TABLE "public"."chat_messages" 
ADD CONSTRAINT "chat_messages_user_id_fkey" 
FOREIGN KEY ("user_id") REFERENCES "public"."user" ("id") ON DELETE CASCADE;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."chat_messages_id_seq" 
OWNED BY "public"."chat_messages"."id";

-- ----------------------------
-- Indexes for table chat_messages
-- ----------------------------
CREATE INDEX "idx_chat_messages_group_id" ON "public"."chat_messages" USING btree ("chat_group_id");
CREATE INDEX "idx_chat_messages_user_id" ON "public"."chat_messages" USING btree ("user_id");
CREATE INDEX "idx_chat_messages_type" ON "public"."chat_messages" USING btree ("type");
CREATE INDEX "idx_chat_messages_created_at" ON "public"."chat_messages" USING btree ("created_at" DESC);
CREATE INDEX "idx_chat_messages_is_read" ON "public"."chat_messages" USING btree ("is_read");
