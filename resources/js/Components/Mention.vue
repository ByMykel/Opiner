<template>
    <div>
        <editor-content
            class="w-full border-none rounded-md p-1 overflow-auto"
            :editor="editor"
        />
        <div
            class="p-0.5 bg-white rounded w-auto"
            v-show="showSuggestions"
            ref="suggestions"
        >
            <template v-if="hasResults">
                <div
                    v-for="(user, index) in filteredUsers"
                    :key="user.id"
                    class="rounded p-1 cursor-pointer hover:bg-blue-100 m-1"
                    :class="{ 'bg-blue-100': navigatedUserIndex === index }"
                    @click="selectUser(user)"
                >
                    {{ user.name }}
                </div>
            </template>
            <div v-else class="rounded p-1 m-1">No users found</div>
        </div>
    </div>
</template>

<script>
import { Editor, EditorContent } from "tiptap";
import { Link } from "tiptap-extensions";
import CustomMention from "./../CustomMention";
import axios from "axios";

export default {
    components: {
        EditorContent,
    },
    data() {
        return {
            json: "",
            html: "",
            editor: new Editor({
                editorProps: {
                    handleTextInput: (view) => {
                        if (
                            this.maxlength &&
                            view.state.doc.textContent.length >=
                                this.maxlength &&
                            view.state.selection.empty
                        ) {
                            return true;
                        }
                    },
                    handlePaste: (view, event, slice) => {
                        if (
                            this.maxlength &&
                            view.state.doc.textContent.length + slice.size >
                                this.maxlength
                        ) {
                            slice.content = new DocumentFragment();
                        }
                    },
                },

                extensions: [
                    new Link(),
                    new CustomMention({
                        onEnter: ({ query, range, command }) => {
                            this.query = query;
                            this.items(query);
                            this.suggestionRange = range;
                            this.insertMention = command;
                        },
                        onChange: ({ query, range }) => {
                            this.query = query;
                            this.items(query);
                            this.suggestionRange = range;
                            this.navigatedUserIndex = 0;
                        },
                        onExit: () => {
                            this.query = null;
                            this.filteredUsers = [];
                            this.suggestionRange = null;
                            this.navigatedUserIndex = 0;
                        },
                        onKeyDown: ({ event }) => {
                            if (event.key === "ArrowUp") {
                                this.upHandler();
                                return true;
                            }
                            if (event.key === "ArrowDown") {
                                this.downHandler();
                                return true;
                            }
                            if (event.key === "Enter") {
                                this.enterHandler();
                                return true;
                            }
                            return false;
                        },
                    }),
                ],
                content: ``,
                onUpdate: ({ getJSON, getHTML }) => {
                    this.json = getJSON();
                    this.html = getHTML();
                    this.$emit("opinionData", this.html);
                    this.$emit(
                        "opinionDataLength",
                        this.editor.state.doc.textContent.length -
                            this.insertMention.length
                    );
                },
            }),
            query: "",
            suggestionRange: null,
            filteredUsers: [],
            navigatedUserIndex: 0,
            insertMention: () => {},
        };
    },
    computed: {
        hasResults() {
            return this.filteredUsers.length;
        },
        showSuggestions() {
            return this.query || this.hasResults;
        },
    },
    methods: {
        upHandler() {
            this.navigatedUserIndex =
                (this.navigatedUserIndex + this.filteredUsers.length - 1) %
                this.filteredUsers.length;
        },
        downHandler() {
            this.navigatedUserIndex =
                (this.navigatedUserIndex + 1) % this.filteredUsers.length;
        },
        enterHandler() {
            const user = this.filteredUsers[this.navigatedUserIndex];
            if (user) {
                this.selectUser(user);
            }
        },
        selectUser(user) {
            this.insertMention({
                range: this.suggestionRange,
                attrs: {
                    id: user.id,
                    label: `${user.username} `,
                },
            });
            this.editor.focus();
        },
        async items(query) {
            let users = await axios.get(route("mention", query));
            this.filteredUsers = users.data;
        },
    },
};
</script>