<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, onMounted, onUnmounted } from "vue";
import CreateTask from "./CreateTask.vue";
import Task from "./Task.vue";
import Draggable from "vuedraggable";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    board: Object,
    members: Array,
});

const board = ref(JSON.parse(JSON.stringify(props.board)));

const createTaskForSection = ref(null);

function tasksMoved(section) {
    if (
        (props.board.sections.find((s) => section.id == s.id)?.tasks || [])
            .length > section.tasks.length
    )
        return;

    Inertia.post(route("sections.tasks.moved", section.id), {
        tasks: section.tasks.map((task) => task.id),
    });
}

let listener = null;

onMounted(() => {
    listener = Inertia.on("finish", () => {
        board.value = JSON.parse(JSON.stringify(props.board));
    });
});

onUnmounted(() => {
    listener();
});
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
                                itemKey="id"
                                group="tasks"
                                class="mt-2 h-[calc(100vh-20vh)] overflow-y-scroll border-gray-300 rounded-md p-1 text-sm space-y-5"
                                @change="tasksMoved(section)"
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
