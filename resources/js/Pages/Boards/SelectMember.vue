<script setup>
import { computed, ref } from "vue";
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import { ChevronRightIcon, UsersIcon } from "@heroicons/vue/24/outline";
import {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

const props = defineProps({
    members: Array,
    open: Boolean,
    selected: Object,
});

const emit = defineEmits(["select", "close"]);

const query = ref("");
const filteredMembers = computed(() =>
    query.value === ""
        ? []
        : props.members.filter((member) => {
              return (
                  member.name
                      .toLowerCase()
                      .includes(query.value.toLowerCase()) ||
                  member.email.toLowerCase().includes(query.value.toLowerCase())
              );
          })
);

function onSelect(member) {
    emit("select", member);
    emit("close");
}
</script>

<template>
    <TransitionRoot :show="open" as="template" @after-leave="query = ''" appear>
        <Dialog as="div" class="relative z-10" @close="$emit('close')">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <DialogPanel
                        class="mx-auto max-w-3xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
                    >
                        <Combobox
                            v-slot="{ activeOption }"
                            @update:modelValue="onSelect"
                        >
                            <div class="relative">
                                <MagnifyingGlassIcon
                                    class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400"
                                    aria-hidden="true"
                                />
                                <ComboboxInput
                                    class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                                    placeholder="Search..."
                                    @change="query = $event.target.value"
                                />
                            </div>

                            <ComboboxOptions
                                v-if="
                                    query === '' || filteredMembers.length > 0
                                "
                                class="flex divide-x divide-gray-100"
                                as="div"
                                static
                                hold
                            >
                                <div
                                    :class="[
                                        'max-h-96 min-w-0 flex-auto scroll-py-4 overflow-y-auto px-6 py-4',
                                        activeOption && 'sm:h-96',
                                    ]"
                                >
                                    <button
                                        class="block w-full bg-gray-50 hover:bg-gray-100 text-sm transition py-3 rounded-md"
                                        @click.prevent="onSelect(null)"
                                        v-if="selected"
                                    >
                                        Remove Selected
                                    </button>

                                    <h2
                                        v-if="query === ''"
                                        class="mt-2 mb-4 text-xs font-semibold text-gray-500"
                                    >
                                        Team Members
                                    </h2>
                                    <div
                                        hold
                                        class="-mx-2 text-sm text-gray-700"
                                    >
                                        <ComboboxOption
                                            v-for="person in query === ''
                                                ? members
                                                : filteredMembers"
                                            :key="person.id"
                                            :value="person"
                                            as="template"
                                            v-slot="{ active }"
                                        >
                                            <div
                                                :class="[
                                                    'group flex cursor-default select-none items-center rounded-md p-2',
                                                    active &&
                                                        'bg-gray-100 text-gray-900',
                                                ]"
                                            >
                                                <img
                                                    :src="
                                                        person.profile_photo_url
                                                    "
                                                    alt=""
                                                    class="h-6 w-6 flex-none rounded-full"
                                                />
                                                <span
                                                    class="ml-3 flex-auto truncate"
                                                    >{{ person.name }}</span
                                                >
                                                <ChevronRightIcon
                                                    v-if="active"
                                                    class="ml-3 h-5 w-5 flex-none text-gray-400"
                                                    aria-hidden="true"
                                                />
                                            </div>
                                        </ComboboxOption>
                                    </div>
                                </div>

                                <div
                                    v-if="activeOption"
                                    class="hidden h-96 w-1/2 flex-none flex-col divide-y divide-gray-100 overflow-y-auto sm:flex"
                                >
                                    <div class="flex-none p-6 text-center">
                                        <img
                                            :src="
                                                activeOption.profile_photo_url
                                            "
                                            alt=""
                                            class="mx-auto h-16 w-16 rounded-full"
                                        />
                                        <h2
                                            class="mt-3 font-semibold text-gray-900"
                                        >
                                            {{ activeOption.name }}
                                        </h2>
                                        <p
                                            class="text-sm leading-6 text-gray-500"
                                        >
                                            {{ activeOption.role }}
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-auto flex-col justify-between p-6"
                                    >
                                        <dl
                                            class="grid grid-cols-1 gap-x-6 gap-y-3 text-sm text-gray-700"
                                        >
                                            <dt
                                                class="col-end-1 font-semibold text-gray-900"
                                            >
                                                Email
                                            </dt>
                                            <dd class="truncate">
                                                <a
                                                    :href="`mailto:${activeOption.email}`"
                                                    class="text-indigo-600 underline"
                                                >
                                                    {{ activeOption.email }}
                                                </a>
                                            </dd>
                                        </dl>
                                        <button
                                            type="button"
                                            class="mt-6 w-full rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                            @click="onSelect(member)"
                                        >
                                            Select Member
                                        </button>
                                    </div>
                                </div>
                            </ComboboxOptions>

                            <div
                                v-if="
                                    query !== '' && filteredMembers.length === 0
                                "
                                class="py-14 px-6 text-center text-sm sm:px-14"
                            >
                                <UsersIcon
                                    class="mx-auto h-6 w-6 text-gray-400"
                                    aria-hidden="true"
                                />
                                <p class="mt-4 font-semibold text-gray-900">
                                    No member found
                                </p>
                                <p class="mt-2 text-gray-500">
                                    We couldn’t find anything with that term.
                                    Please try again.
                                </p>
                            </div>
                        </Combobox>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
