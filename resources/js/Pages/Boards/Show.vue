<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref } from "vue";
import CreateTask from "./CreateTask.vue";
import Task from "./Task.vue";
import Draggable from "vuedraggable";

defineProps({
    board: Object,
    members: Array,
});

const createTaskForSection = ref(null);
</script>

<template>
    <AppLayout :title="board.name + `- Board`">
        <div class="py-12">
            <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-x-scroll flex gap-x-5">
                    <div
                        class="min-w-[350px]"
                        v-for="section in board.sections"
                        :key="section.id"
                    >
                        <h3 class="text-sm font-semibold">
                            {{ section.name }}
                        </h3>

                        <div>
                            <Draggable
                                v-model="section.tasks"
                                item-key="id"
                                group="tasks"
                                class="mt-2 h-[calc(100vh-20vh)] overflow-y-scroll border-gray-300 rounded-md p-1 text-sm space-y-5"
                            >
                                <template #item="{ element }">
                                    <div>
                                        <Task
                                            :members="members"
                                            :task="element"
                                        />
                                    </div>
                                </template>

                                <template #footer>
                                    <button
                                        class="mt-5 w-full text-center py-2 bg-gray-50 hover:shadow rounded-md transition"
                                        @click="createTaskForSection = section"
                                    >
                                        Add Task
                                    </button>
                                </template>
                            </Draggable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

    <CreateTask
        :section="createTaskForSection"
        :open="createTaskForSection ? true : false"
        @close="createTaskForSection = null"
    />
</template>
