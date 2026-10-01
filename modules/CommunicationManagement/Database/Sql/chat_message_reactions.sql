-- ----------------------------
-- Sequence structure for chat_message_reactions_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."chat_message_reactions_id_seq";
CREATE SEQUENCE "public"."chat_message_reactions_id_seq" 
    INCREMENT 1 
    MINVALUE 1 
    MAXVALUE 9223372036854775807 
    START 1 
    CACHE 1;

-- ----------------------------
-- Table structure for chat_message_reactions
-- ----------------------------
DROP TABLE IF EXISTS "public"."chat_message_reactions";
CREATE TABLE "public"."chat_message_reactions" (
    "id" int8 NOT NULL DEFAULT nextval('chat_message_reactions_id_seq'::regclass),
    "chat_message_id" int8 NOT NULL,
    "user_id" int8 NOT NULL,
    "emoji" varchar(255) NOT NULL,
    "created_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP,
    "updated_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP
);

-- ----------------------------
-- Primary Key structure for table chat_message_reactions
-- ----------------------------
ALTER TABLE "public"."chat_message_reactions" ADD CONSTRAINT "chat_message_reactions_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Uniqueness constraint
-- ----------------------------
ALTER TABLE "public"."chat_message_reactions" ADD CONSTRAINT "chat_message_reactions_user_message_emoji_unique" UNIQUE ("user_id", "chat_message_id", "emoji");

-- ----------------------------
-- Foreign Key constraints
-- ----------------------------
ALTER TABLE "public"."chat_message_reactions" ADD CONSTRAINT "chat_message_reactions_chat_message_id_fkey" 
FOREIGN KEY ("chat_message_id") REFERENCES "public"."chat_messages" ("id") ON DELETE CASCADE;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."chat_message_reactions_id_seq" OWNED BY "public"."chat_message_reactions"."id";

-- ----------------------------
-- Indexes for table chat_message_reactions
-- ----------------------------
CREATE INDEX "idx_chat_message_reactions_message_id" ON "public"."chat_message_reactions" USING btree ("chat_message_id");
CREATE INDEX "idx_chat_message_reactions_user_id" ON "public"."chat_message_reactions" USING btree ("user_id");
