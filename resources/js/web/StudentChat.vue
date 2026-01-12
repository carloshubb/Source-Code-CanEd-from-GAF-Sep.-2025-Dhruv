<template>
    <div class="tab-content tab-space">
        <div class="block" id="tab-chat">
            <div>
                <h1 class="mb-5 text-gray-900 font-bold text-3xl">Chat</h1>
                <!-- component -->
                <div
                    class="flex-1 justify-between flex flex-col h-screen border rounded"
                >
                    <div
                        class="flex flex-initial sm:items-center justify-between py-3 border-b-2 border-gray-200 px-4"
                    >
                        <div class="relative flex items-center space-x-4">
                            <div class="relative">
                                <span
                                    class="absolute text-green-500 -right-1 -bottom-1"
                                >
                                    <svg width="20" height="20">
                                        <circle
                                            cx="8"
                                            cy="8"
                                            r="8"
                                            fill="currentColor"
                                        ></circle>
                                    </svg>
                                </span>
                                <img
                                    :src="
                                         customer?.image ? customer?.image : ''
                                    "
                                    alt=""
                                    class="w-10 sm:w-14 h-10 sm:h-14 rounded-full"
                                />
                            </div>
                            <div class="flex flex-col leading-tight">
                                <div class="text-lg mt-1 flex items-center">
                                    <span class="text-gray-700 mr-3">
                                        {{
                                            customer.first_name
                                                ? customer.first_name
                                                : "" + " " + customer.last_name
                                                ? customer.last_name
                                                : ""
                                        }}
                                    </span>
                                </div>
                                <!-- <span
                                    class="font-semibold text-sm leading-5 text-gray-600"
                                    >{{
                                        ambassador?.category
                                            ? ambassador?.category
                                            : ""
                                    }}</span
                                > -->
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="relative">
                                <button
                                    @click="toggleTooltip"
                                    type="button"
                                    class="inline-flex items-center justify-center h-10 w-10 transition duration-500 ease-in-out text-gray-500 hover:bg-gray-300 focus:outline-none"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-6 h-6"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"
                                        />
                                    </svg>
                                </button>
                                <div
                                    v-if="showTooltip"
                                    class="absolute bg-gray-200 text-gray-800 px-2 py-1 rounded mt-2"
                                    style="width: 200px"
                                >
                                    <div class="grid grid-cols-3 gap-2">
                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="
                                                schedualMeeting(
                                                    'skype',
                                                    ambassador?.skype_id
                                                )
                                            "
                                            v-if="ambassador?.skype_id != ''"
                                        >
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                fill="currentColor"
                                                class="text-[#00aff0]"
                                            >
                                                <path
                                                    class="cls-1"
                                                    d="m13.71,22.97c-.56.09-1.13.13-1.71.13C5.87,23.1.9,18.13.9,12c0-.58.04-1.15.13-1.71-.5-.95-.78-2.04-.78-3.19C.25,3.32,3.32.25,7.1.25c1.15,0,2.23.28,3.19.78.56-.09,1.13-.13,1.71-.13,6.13,0,11.1,4.97,11.1,11.1,0,.58-.04,1.15-.13,1.71.5.95.78,2.04.78,3.19,0,3.79-3.07,6.85-6.85,6.85-1.15,0-2.23-.28-3.19-.78Zm-1.64-4.24h-.05c3.75,0,5.62-1.81,5.62-4.23,0-1.56-.72-3.23-3.56-3.86l-2.59-.57c-.99-.22-2.12-.52-2.12-1.46s.81-1.58,2.25-1.58c2.91,0,2.65,1.99,4.09,1.99.75,0,1.43-.45,1.43-1.21,0-1.79-2.87-3.13-5.29-3.13-2.64,0-5.45,1.12-5.45,4.1,0,1.43.51,2.96,3.34,3.67l3.51.88c1.07.26,1.33.86,1.33,1.4,0,.9-.89,1.77-2.5,1.77-3.16,0-2.71-2.43-4.41-2.43-.76,0-1.31.52-1.31,1.27,0,1.45,1.76,3.39,5.71,3.39Z"
                                                />
                                            </svg>
                                        </div>
                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="
                                                schedualMeeting(
                                                    'whats_app',
                                                    ambassador?.whats_app_number
                                                )
                                            "
                                            v-if="
                                                ambassador?.whats_app_number != ''
                                            "
                                        >
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                fill="currentColor"
                                                class="text-[#25D366]"
                                            >
                                                <path
                                                    class="cls-1"
                                                    d="m12,.17c6.53,0,11.83,5.3,11.83,11.83s-5.3,11.83-11.83,11.83c-2.17,0-4.2-.58-5.95-1.6L.17,23.83l1.6-5.88c-1.02-1.75-1.6-3.78-1.6-5.95C.17,5.47,5.47.17,12,.17Zm-4.03,6.27h-.24c-.15.02-.3.06-.44.13-.1.05-.2.13-.35.27-.14.13-.22.25-.31.36-.44.57-.67,1.27-.67,1.99,0,.58.15,1.14.39,1.67.48,1.07,1.28,2.2,2.33,3.24.25.25.5.51.77.74,1.31,1.15,2.86,1.98,4.54,2.42,0,0,.66.1.67.1.22.01.44,0,.66-.02.34-.02.68-.11.99-.27.2-.1.29-.16.45-.26,0,0,.05-.03.15-.11.16-.12.26-.2.39-.34.1-.1.18-.22.25-.36.09-.19.19-.56.22-.87.03-.23.02-.36.02-.44,0-.13-.11-.26-.23-.31l-.69-.31s-1.03-.45-1.66-.73c-.07-.03-.14-.04-.21-.05-.16,0-.33.03-.45.15,0,0-.08.07-.94,1.1-.05.06-.16.18-.35.17-.03,0-.06,0-.09-.01-.08-.02-.15-.05-.23-.08-.15-.06-.2-.09-.3-.13-.68-.3-1.31-.7-1.86-1.19-.15-.13-.29-.27-.43-.41-.5-.48-.9-.99-1.21-1.5-.02-.03-.04-.07-.07-.11-.05-.08-.1-.18-.12-.24-.04-.17.07-.31.07-.31,0,0,.29-.31.42-.49.13-.16.24-.33.31-.44.14-.22.18-.46.11-.63-.33-.81-.67-1.61-1.03-2.41-.07-.16-.28-.27-.47-.29-.06,0-.13-.01-.19-.02-.16,0-.32,0-.48,0h.24Z"
                                                />
                                            </svg>
                                        </div>
                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="
                                                schedualMeeting(
                                                    'imo',
                                                    ambassador?.imo_number
                                                )
                                            "
                                            v-if="ambassador?.imo_number != ''"
                                        >
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="text-[#00aff0]"
                                            >
                                                <path
                                                    class="cls-1"
                                                    d="m23.52,12.26C23.52,5.92,18.35.75,12,.75S.49,5.92.49,12.26c0,1.96.51,3.9,1.47,5.62.01.04.03.08.05.11.36.55-.77,1.63-1.33,2.04-.14.1-.21.27-.19.43.01.17.12.32.27.39.08.04,1.83.85,3.7.1,2.1,1.83,4.77,2.83,7.55,2.83,6.35,0,11.52-5.17,11.52-11.52Zm-9.69,9.42c-3.17.59-6.11-.39-8.22-2.28-1.5.73-3.02.26-3.02.26l.02-.02c.94-.94,1.12-2.36.59-3.58-.75-1.73-1.02-3.72-.59-5.81.78-3.83,3.94-6.85,7.81-7.47,6.56-1.05,12.13,4.55,11.05,11.11-.64,3.91-3.74,7.07-7.63,7.79Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m5.74,10.34c-.27,0-.49.21-.49.48v3.84c0,.27.22.48.49.48s.49-.21.49-.48v-3.84c0-.26-.22-.48-.49-.48Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m16.8,10.34c-1.06,0-1.95.86-1.95,1.92v.97c0,1.06.89,1.92,1.95,1.92s1.94-.86,1.94-1.92v-.96c0-1.06-.89-1.93-1.94-1.93Zm.97,2.89c0,.53-.44.96-.97.96s-.97-.43-.97-.96v-.96c0-.53.44-.96.97-.96s.97.43.97.96v.96Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m12.01,10.34c-.58,0-1.1.26-1.45.66-.35-.4-.87-.66-1.45-.66-.37,0-.71.1-1.01.29-.08-.17-.24-.29-.43-.29-.27,0-.48.21-.48.48v3.84c0,.27.22.48.49.48s.49-.21.49-.48v-2.4c0-.53.41-.96.94-.96s.94.43.94.96v2.4c0,.27.22.48.49.48s.49-.21.49-.48v-2.4c0-.53.44-.96.97-.96s.97.43.97.96v2.4c0,.27.22.48.49.48s.49-.21.49-.48v-2.4c0-1.06-.88-1.92-1.93-1.92Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m5.76,8.42c-.27,0-.48.21-.48.48s.21.48.48.48.48-.21.48-.48-.21-.48-.48-.48Z"
                                                />
                                            </svg>
                                        </div>
                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="
                                                schedualMeeting(
                                                    'viber',
                                                    ambassador?.viber_number
                                                )
                                            "
                                            v-if="ambassador?.viber_number != ''"
                                        >
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="text-[#7360f2]"
                                            >
                                                <path
                                                    class="cls-1"
                                                    d="m21.94,5.69c-.41-.97-1-1.84-1.75-2.59-.75-.75-1.62-1.34-2.59-1.75-.6-.25-1.22-.43-1.85-.54-.02,0-.03,0-.04,0-.42-.07-.84-.1-1.27-.1h-5.54c-1.1,0-2.16.22-3.17.64-.97.41-1.84,1-2.59,1.75-.75.75-1.34,1.62-1.75,2.59-.43,1.01-.64,2.07-.64,3.17v3.73c0,1.66.5,3.26,1.45,4.63.75,1.08,1.74,1.96,2.89,2.57.23.12.47.24.72.34,0,0,0,0,0,0,0,0,0,0,0,0,.06.02.11.05.17.07,0,0,0,0,0,0l-.03,2.67h0v.02c0,.38.22.71.54.88,0,0,0,0,0,0,.08.02.17.03.26.03.28,0,.56-.12.75-.33l2.49-2.76s0,0,0,0h4.44c1.1,0,2.16-.22,3.17-.64.97-.41,1.84-1,2.59-1.75.75-.75,1.34-1.62,1.75-2.59.43-1.01.64-2.07.64-3.17v-3.73c0-1.1-.22-2.16-.64-3.17h0ZM6.76,22.97l-.09.1c0-1.34,0-2.68-.01-4.02,0-.15,0-.32-.1-.44-.09-.11-.23-.15-.36-.2-1.63-.56-2.8-2.05-3.35-3.68s-.56-3.39-.46-5.11c.19-3.41,1.67-6.42,5.31-7.09,1.28-.24,2.6-.19,3.9-.19,2.3,0,4.78-.1,6.66,1.22,1.19.83,1.97,2.16,2.37,3.55s.44,2.87.38,4.32c-.09,1.98-.42,4.09-1.75,5.57-.92,1.02-2.22,1.62-3.57,1.9s-2.73.24-4.09.14c-.4-.03-.82-.06-1.17.13-.22.11-.39.3-.55.48-1.03,1.11-2.06,2.22-3.09,3.34Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m16.11,13.45c-.26-.14-1.54-.83-1.78-.93-.24-.1-.42-.15-.6.11-.19.26-.72.84-.88,1.01-.31.32-.9-.1-1.23-.29-.38-.21-.89-.54-1.43-1.06-.76-.73-1.26-1.62-1.41-1.89-.22-.41.55-.9.79-1.34.01-.02.03-.05.04-.08.09-.17.06-.33,0-.47-.06-.13-.54-1.46-.74-2-.26-.68-1.38-.63-1.81-.2-.25.26-.96.87-1.01,2.18-.05,1.31.85,2.6.98,2.78.13.18,1.73,3.01,4.38,4.18,1.57.69,2.83,1.33,4.34.3.3-.2.55-.45.66-.71.24-.61.26-1.14.2-1.26-.06-.11-.24-.19-.5-.33Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m11.23,6.28c-.18,0-.33-.13-.33-.31,0-.18.13-.33.31-.33.25,0,.5,0,.73.01,1.34.11,2.52.66,3.37,1.52.86.86,1.39,2.02,1.44,3.35,0,.22,0,.45-.01.67-.01.18-.17.31-.35.3s-.31-.17-.3-.35c.02-.2.02-.4.01-.59-.05-1.15-.51-2.17-1.26-2.92-.75-.75-1.78-1.24-2.97-1.33-.22-.02-.44-.02-.65-.01Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m11.85,7.54c-.18-.03-.3-.19-.27-.37.03-.18.19-.3.37-.27.95.14,1.79.56,2.41,1.18.62.62,1.02,1.43,1.12,2.36.02.18-.11.34-.29.35-.18.02-.34-.11-.35-.29-.08-.77-.42-1.45-.93-1.97-.52-.52-1.23-.88-2.05-1Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m11.92,8.89c-.17-.05-.26-.24-.21-.41.05-.17.24-.26.41-.21.52.17.9.37,1.19.68.29.3.5.68.69,1.2.06.17-.03.35-.19.41-.17.06-.35-.03-.41-.19-.16-.44-.32-.75-.55-.97-.22-.22-.51-.38-.93-.51Z"
                                                />
                                            </svg>
                                        </div>
                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="
                                                schedualMeeting(
                                                    'phone_call',
                                                    ambassador?.mobile_number
                                                )
                                            "
                                            v-if="ambassador?.mobile_number != ''"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                fill="currentColor"
                                                class="text-[#7330f2]"
                                                version="1.1"
                                                id="Capa_1"
                                                viewBox="0 0 473.806 473.806"
                                                xml:space="preserve"
                                            >
                                                <g>
                                                    <g>
                                                        <path
                                                            d="M374.456,293.506c-9.7-10.1-21.4-15.5-33.8-15.5c-12.3,0-24.1,5.3-34.2,15.4l-31.6,31.5c-2.6-1.4-5.2-2.7-7.7-4    c-3.6-1.8-7-3.5-9.9-5.3c-29.6-18.8-56.5-43.3-82.3-75c-12.5-15.8-20.9-29.1-27-42.6c8.2-7.5,15.8-15.3,23.2-22.8    c2.8-2.8,5.6-5.7,8.4-8.5c21-21,21-48.2,0-69.2l-27.3-27.3c-3.1-3.1-6.3-6.3-9.3-9.5c-6-6.2-12.3-12.6-18.8-18.6    c-9.7-9.6-21.3-14.7-33.5-14.7s-24,5.1-34,14.7c-0.1,0.1-0.1,0.1-0.2,0.2l-34,34.3c-12.8,12.8-20.1,28.4-21.7,46.5    c-2.4,29.2,6.2,56.4,12.8,74.2c16.2,43.7,40.4,84.2,76.5,127.6c43.8,52.3,96.5,93.6,156.7,122.7c23,10.9,53.7,23.8,88,26    c2.1,0.1,4.3,0.2,6.3,0.2c23.1,0,42.5-8.3,57.7-24.8c0.1-0.2,0.3-0.3,0.4-0.5c5.2-6.3,11.2-12,17.5-18.1c4.3-4.1,8.7-8.4,13-12.9    c9.9-10.3,15.1-22.3,15.1-34.6c0-12.4-5.3-24.3-15.4-34.3L374.456,293.506z M410.256,398.806    C410.156,398.806,410.156,398.906,410.256,398.806c-3.9,4.2-7.9,8-12.2,12.2c-6.5,6.2-13.1,12.7-19.3,20    c-10.1,10.8-22,15.9-37.6,15.9c-1.5,0-3.1,0-4.6-0.1c-29.7-1.9-57.3-13.5-78-23.4c-56.6-27.4-106.3-66.3-147.6-115.6    c-34.1-41.1-56.9-79.1-72-119.9c-9.3-24.9-12.7-44.3-11.2-62.6c1-11.7,5.5-21.4,13.8-29.7l34.1-34.1c4.9-4.6,10.1-7.1,15.2-7.1    c6.3,0,11.4,3.8,14.6,7c0.1,0.1,0.2,0.2,0.3,0.3c6.1,5.7,11.9,11.6,18,17.9c3.1,3.2,6.3,6.4,9.5,9.7l27.3,27.3    c10.6,10.6,10.6,20.4,0,31c-2.9,2.9-5.7,5.8-8.6,8.6c-8.4,8.6-16.4,16.6-25.1,24.4c-0.2,0.2-0.4,0.3-0.5,0.5    c-8.6,8.6-7,17-5.2,22.7c0.1,0.3,0.2,0.6,0.3,0.9c7.1,17.2,17.1,33.4,32.3,52.7l0.1,0.1c27.6,34,56.7,60.5,88.8,80.8    c4.1,2.6,8.3,4.7,12.3,6.7c3.6,1.8,7,3.5,9.9,5.3c0.4,0.2,0.8,0.5,1.2,0.7c3.4,1.7,6.6,2.5,9.9,2.5c8.3,0,13.5-5.2,15.2-6.9    l34.2-34.2c3.4-3.4,8.8-7.5,15.1-7.5c6.2,0,11.3,3.9,14.4,7.3c0.1,0.1,0.1,0.1,0.2,0.2l55.1,55.1    C420.456,377.706,420.456,388.206,410.256,398.806z"
                                                        />
                                                        <path
                                                            d="M256.056,112.706c26.2,4.4,50,16.8,69,35.8s31.3,42.8,35.8,69c1.1,6.6,6.8,11.2,13.3,11.2c0.8,0,1.5-0.1,2.3-0.2    c7.4-1.2,12.3-8.2,11.1-15.6c-5.4-31.7-20.4-60.6-43.3-83.5s-51.8-37.9-83.5-43.3c-7.4-1.2-14.3,3.7-15.6,11    S248.656,111.506,256.056,112.706z"
                                                        />
                                                        <path
                                                            d="M473.256,209.006c-8.9-52.2-33.5-99.7-71.3-137.5s-85.3-62.4-137.5-71.3c-7.3-1.3-14.2,3.7-15.5,11    c-1.2,7.4,3.7,14.3,11.1,15.6c46.6,7.9,89.1,30,122.9,63.7c33.8,33.8,55.8,76.3,63.7,122.9c1.1,6.6,6.8,11.2,13.3,11.2    c0.8,0,1.5-0.1,2.3-0.2C469.556,223.306,474.556,216.306,473.256,209.006z"
                                                        />
                                                    </g>
                                                </g>
                                            </svg>
                                        </div>
                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="
                                                schedualMeeting(
                                                    'wechat',
                                                    ambassador?.we_chat_number
                                                )
                                            "
                                            v-if="
                                                ambassador?.we_chat_number != ''
                                            "
                                        >
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    class="cls-1"
                                                    d="m17.06,8.79c-.12,0-.21-.02-.3-.02-1.06-.01-2.09.14-3.09.49-1.02.36-1.94.88-2.74,1.62-.79.73-1.37,1.59-1.7,2.62-.34,1.06-.34,2.13-.02,3.2,0,.03.02.06.03.09,0,0,0,.02,0,.04-.06,0-.13.01-.19.02-.98.02-1.94-.08-2.88-.36-.35-.1-.65-.02-.94.16-.54.33-1.09.63-1.64.95-.15.09-.28.1-.37.01-.11-.1-.11-.22-.08-.36.13-.49.27-.99.39-1.48.07-.29-.01-.48-.25-.65-1.21-.9-2.11-2.03-2.58-3.48-.15-.47-.23-.95-.26-1.45-.06-1.06.16-2.06.64-3,.54-1.07,1.33-1.93,2.3-2.62,1.14-.81,2.41-1.3,3.78-1.52,1.66-.27,3.29-.14,4.88.41,1.03.36,1.96.88,2.78,1.59.98.85,1.71,1.88,2.09,3.13.06.19.1.39.16.61Zm-4.37-1.14c0-.59-.49-1.1-1.07-1.11-.64,0-1.15.47-1.16,1.09-.01.61.49,1.13,1.1,1.14.62,0,1.12-.49,1.13-1.12Zm-5.57,0c0-.61-.5-1.1-1.12-1.1-.63,0-1.11.5-1.11,1.15,0,.56.52,1.08,1.11,1.08.62,0,1.13-.5,1.13-1.13Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m16.59,9.31c1.08.02,2.12.21,3.11.62,1.12.47,2.09,1.16,2.83,2.14.59.78.95,1.66,1.03,2.63.09,1.09-.16,2.11-.73,3.05-.43.7-.99,1.28-1.64,1.77-.18.14-.24.31-.19.53.11.42.23.84.33,1.26.04.17-.04.31-.2.31-.07,0-.14-.03-.2-.06-.31-.18-.62-.36-.93-.54-.19-.11-.37-.22-.56-.32-.18-.1-.37-.13-.57-.07-.92.27-1.86.36-2.81.3-.79-.05-1.57-.21-2.32-.49-.85-.32-1.62-.77-2.3-1.39-.94-.86-1.57-1.91-1.77-3.18-.15-.94-.02-1.86.37-2.73.51-1.15,1.35-2.01,2.41-2.67.88-.55,1.85-.89,2.87-1.04.42-.06.84-.08,1.26-.12Zm-2.33,4.9c.52,0,.95-.41.95-.93,0-.49-.42-.92-.91-.93-.52,0-.95.42-.95.94,0,.49.42.92.92.92Zm5.59-.93c0-.5-.41-.92-.92-.92-.51,0-.93.41-.93.93,0,.51.41.92.92.93.52,0,.93-.4.94-.93Z"
                                                />
                                            </svg>
                                        </div>

                                        <div
                                            class="cursor-pointer p-2 w-10"
                                            @click="schedualMeeting('zoom', '')"
                                        >
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="text-[#2D8CFF]"
                                            >
                                                <rect
                                                    class="cls-2"
                                                    x=".36"
                                                    y=".36"
                                                    width="23.29"
                                                    height="23.29"
                                                    rx="3.28"
                                                    ry="3.28"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m5.17,7.66h7.82c1.17,0,2.13.95,2.13,2.13v5.18c0,.55-.44.99-.99.99H5.17c-.55,0-.99-.44-.99-.99v-6.32c0-.55.44-.99.99-.99Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m15.95,10.1l2.59-1.81c.38-.27.9,0,.9.47v6.11c0,.46-.52.73-.9.47l-2.59-1.76c-.21-.15-.34-.39-.34-.65v-2.2c0-.26.12-.49.33-.64Z"
                                                />
                                            </svg>
                                        </div>
                                        <div class="cursor-pointer p-2 w-10"
                                            @click="schedualMeeting('google_meet', '')">
                                            <svg
                                                id="Layer_1"
                                                data-name="Layer 1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    class="cls-5"
                                                    d="m0,16.38v3.65c0,1.03.84,1.88,1.86,1.88h15.7c.87,0,1.58-.72,1.58-1.6v-3.73l-5.58-4.56v4.36H0Zm16.93-7.31l-3.37,2.95v-2.95h3.37Z"
                                                />
                                                <path
                                                    class="cls-1"
                                                    d="m17.56,2.09H5.62v5.73h7.94v4.21l.38-.25,5.2-.05V3.68c0-.88-.71-1.6-1.58-1.6Z"
                                                />
                                                <path
                                                    class="cls-2"
                                                    d="m0,7.82v12.22c0,1.03.84,1.88,1.86,1.88h3.77V7.82H0Z"
                                                />
                                                <rect
                                                    class="cls-7"
                                                    y="7.82"
                                                    width="5.62"
                                                    height="8.57"
                                                />
                                                <polygon
                                                    class="cls-4"
                                                    points="0 7.82 5.62 2.09 5.62 7.82 0 7.82"
                                                />
                                                <g>
                                                    <polygon
                                                        class="cls-6"
                                                        points="13.56 12.03 19.06 16.65 19.06 7.55 13.56 12.03"
                                                    />
                                                    <path
                                                        class="cls-3"
                                                        d="m19.06,7.55v9.1l3.47,2.92c.5.42,1.46.31,1.46-.49V5.19c0-.67-.76-1.04-1.3-.6l-3.64,2.96Z"
                                                    />
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        id="messages"
                        class="flex flex-col flex-auto space-y-4 p-3 bg-gray-100 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch"
                    >
                        <div class="flex justify-center">
                            <div
                                class="w-full md:w-3/5 bg-amber-100 border rounded-full mx-auto px-3 py-1.5 flex items-center justify-center"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="w-4 h-4 mr-1"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <p class="text-gray-600 text-xs md:text-sm font-medium">
                                    Messages you send to this chat are secure
                                    and kept anonymised.
                                </p>
                            </div>
                        </div>
                        <div class="flex justify-center items-center">
                            <p class="text-gray-600">Jun 9, 2023</p>
                        </div>
                        <div
                            v-for="message in messages"
                            :key="message.id"
                            class="chat-message"
                        >
                            <div
                                :class="
                                    message?.type == 'customer'
                                        ? 'flex items-start'
                                        : 'flex items-start justify-end'
                                "
                            >
                                <div
                                    :class="
                                        message?.type == 'customer'
                                            ? 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-2 items-start'
                                            : 'flex flex-col space-y-2 text-sm font-medium max-w-lg mx-2 order-1 justify-end'
                                    "
                                >
                                    <div
                                        :class="
                                            message?.type == 'customer'
                                                ? 'bg-white px-4 py-2 rounded-lg inline-block text-gray-600'
                                                : 'px-4 py-2 rounded-lg bg-blue-600 text-white'
                                        "
                                    >
                                        <div class="mb-3">
                                            {{ message.message }}
                                        </div>
                                        <time>{{ message.created_at }}</time>
                                    </div>
                                </div>
                                <img
                                    :src="
                                         message.type == 'customer'
                                            ? message?.conversation?.customer
                                                  ?.image
                                            : message?.conversation
                                                  ?.school_ambassador?.image
                                    "
                                    alt="My profile"
                                    :class="
                                        message.type == 'customer'
                                            ? 'w-6 h-6 rounded-full order-1'
                                            : 'w-6 h-6 rounded-full order-2'
                                    "
                                />
                            </div>
                        </div>
                    </div>
                    <div
                        class="border-t-2 flex-initial border-white p-1.5 mb-2 sm:mb-0"
                    >
                        <div class="relative flex">
                            <form @submit.prevent="saveMessage">
                                <input
                                    type="text"
                                    required
                                    v-model="message"
                                    placeholder="Type here..."
                                    class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 placeholder:font-medium pl-4 bg-white py-2"
                                />
                                <div
                                    class="absolute right-0 items-center inset-y-0 hidden sm:flex"
                                >
                                    <button
                                        type="submit"
                                        class="inline-flex rounded px-6 py-1.5 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none"
                                    >
                                        <span class="font-bold">Send</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div
        v-if="app != ''"
        id="modal"
        class="fixed z-50 inset-0 overflow-y-auto p-4"
    >
        <div class="flex items-center justify-center min-h-screen">
            <div
                class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
            ></div>
            <div
                class="modal-container bg-white w-full md:w-3/5 mx-auto rounded shadow-lg overflow-y-auto"
            >
                <div class="modal-content py-6 text-left px-6">
                    <div class="flex justify-between items-center pb-3">
                        <h2 class="can-edu-h2 mb-0">Please select date and time</h2>
                        <div
                            class="modal-close cursor-pointer z-50 border border-primary p-1.5 rounded-full"
                            @click="closeModal"
                        >
                            <svg
                                class="fill-current text-primary"
                                xmlns="http://www.w3.org/2000/svg"
                                width="12"
                                height="12"
                                viewBox="0 0 18 18"
                            >
                                <path
                                    d="M18 1.1L16.9 0 9 7.9 1.1 0 0 1.1 7.9 9 0 16.9 1.1 18 9 10.1l7.9 7.9 1.1-1.1-7.9-7.9z"
                                />
                            </svg>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="w-full mt-4">
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Date</label>
                            <input
                                type="date"
                                placeholder="Date"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                                v-model="date"
                            />
                        </div>
                        <div class="w-full mt-4">
                            <label class="text-gray-700 font-semibold text-sm lg:text-base">Time</label>
                            <input
                                type="time"
                                placeholder="Time"
                                v-model="time"
                                class="mt-1 border w-full border-l-[5px] focus:ring-primary focus:outline-none border-l-primary px-4 py-1.5 rounded border-gray-300"
                            />
                        </div>

                        <div class="flex justify-end items-center gap-3 mt-4">
                            <div class="space-x-4">
                                <button
                                    class="can-edu-btn-fill"
                                    @click="closeModal"
                                >
                                    Close
                                </button>
                                <button
                                    class="can-edu-btn-fill"
                                    @click="saveSchedualMessage"
                                >
                                    Done
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ErrorHandling from "../ErrorHandling";
export default {
    props: [
        "customer_id",
        "customer_object",
        "ambassador_id",
        "ambassador_object",
    ],
    data() {
        return {
            messages: [],
            message: "",
            type: "ambassador",
            ambassador: null,
            customer: null,
            errors: new ErrorHandling(),
            showTooltip: false,
            app: "",
            date: "",
            time: "",
            info: "",
        };
    },
    methods: {
        saveSchedualMessage() {
            if (this.time == "" || this.date == "") {
                helper.swalErrorMessage("Please select a date and time");
            } else {
                console.log(this.app, this.time, this.date, this.info);

                let messageToSend = "";
                if (this.app == "skype") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on your Skype id " +
                        this.info;
                }
                if (this.app == "whats_app") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on your Whats app " +
                        this.info;
                }
                if (this.app == "imo") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on your Imo account " +
                        this.info;
                }
                if (this.app == "viber") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on your Viber account " +
                        this.info;
                }
                if (this.app == "phone_call") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on Phone call on " +
                        this.info;
                }
                if (this.app == "wechat") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on Wechat number " +
                        this.info;
                }
                if (this.app == "zoom") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on zoom " +
                        this.info;
                }
                if (this.app == "google_meet") {
                    messageToSend =
                        "hi lets have a meeting on " +
                        this.date +
                        " at " +
                        this.time +
                        " on Google meet" +
                        this.info;
                }
                this.message = messageToSend;
                this.saveMessage();
                setTimeout(() => {
                    this.closeModal();
                });
            }
        },
        closeModal() {
            this.app = "";
            this.time = "";
            this.date = "";
            this.info = "";
        },
        schedualMeeting(app, info) {
            this.app = app;
            this.info = info;
            this.toggleTooltip();
        },
        toggleTooltip() {
            this.showTooltip = !this.showTooltip;
        },
        saveMessage() {
            axios
                .post("/api/web/save-message", {
                    ambassador_id: this.ambassador_id,
                    customer_id: this.customer_id,
                    message: this.message,
                    type: this.type,
                    app: this.app,
                })
                .then((res) => {
                    console.log(res.data.status);
                    if (res.data.status == "Success") {
                        this.messages.push(res.data.data);
                        this.message = "";
                        setTimeout(() => {
                            var objDiv = document.getElementById("messages");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 200);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => (this.$parent.loading = false));
        },
        fetchMessages() {
            axios
                .post("/api/web/messages", {
                    ambassador_id: this.ambassador_id,
                    customer_id: this.customer_id,
                })
                .then((res) => {
                    if (res.data.status == "Success") {
                        this.messages = res.data.data;
                        setTimeout(() => {
                            var objDiv = document.getElementById("messages");
                            objDiv.scrollTop = objDiv.scrollHeight;
                        }, 1000);
                    }
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => (this.$parent.loading = false));
        },
    },
    created() {
        this.ambassador = JSON.parse(this.ambassador_object);
        console.log(this.ambassador)
        this.customer = JSON.parse(this.customer_object);
        // this.customer = this.customer_object;
        this.fetchMessages();
        Echo.channel("my-channel").listen(".my-event", (data) => {
            this.fetchMessages();
        });
    },
};
</script>
