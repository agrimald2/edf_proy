<template>
    <div>
        <div class="flex justify-center items-center ">
            <svg width="60" height="49" viewBox="0 0 60 49" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="37" cy="27" r="18" fill="#C6372A" />
                <g filter="url(#filter0_d_294_2)">
                    <path
                        d="M54.939 6.29104L49.5588 1.04026C48.8865 0.374075 47.976 0 47.0267 0C46.0775 0 45.167 0.374075 44.4947 1.04026L23.7158 21.4438L15.4907 13.5097C14.817 12.8457 13.9062 12.4741 12.9575 12.4762C12.0088 12.4782 11.0996 12.8539 10.4288 13.5209L5.0486 18.8697C4.37714 19.5383 4 20.4445 4 21.3892C4 22.334 4.37714 23.2402 5.0486 23.9088L21.1041 39.9553C21.4372 40.2865 21.8326 40.5492 22.2679 40.7285C22.7031 40.9077 23.1696 41 23.6407 41C24.1118 41 24.5782 40.9077 25.0135 40.7285C25.4487 40.5492 25.8441 40.2865 26.1772 39.9553L54.9503 11.3435C55.284 11.0114 55.5486 10.6172 55.7287 10.1832C55.9088 9.74934 56.001 9.28435 56 8.81494C55.999 8.34552 55.9047 7.88094 55.7226 7.44783C55.5406 7.01472 55.2743 6.6216 54.939 6.29104ZM23.6306 37.4391L7.57507 21.3926L12.9553 16.0438C12.9618 16.0491 12.9678 16.0551 12.9732 16.0616L22.4671 25.2192C22.8022 25.5453 23.2525 25.7278 23.7214 25.7278C24.1903 25.7278 24.6405 25.5453 24.9756 25.2192L47.0436 3.56313L52.4103 8.82282L23.6306 37.4391Z"
                        fill="black" />
                </g>
                <defs>
                    <filter id="filter0_d_294_2" x="0" y="0" width="60" height="49" filterUnits="userSpaceOnUse"
                        color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                            result="hardAlpha" />
                        <feOffset dy="4" />
                        <feGaussianBlur stdDeviation="2" />
                        <feComposite in2="hardAlpha" operator="out" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_294_2" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_294_2" result="shape" />
                    </filter>
                </defs>
            </svg>
        </div>
        <div class="text-center mb-10 pt-2">
            <h2 class="text-lg font-bold">Rechazaste con éxito la permuta</h2>
            <p>Podrás visualizar el detalle en tu listado de permutas</p>
        </div>
        <div>
            <div class="mt-2 text-center bg-black border rounded-lg py-2 border-black font-medium">
                <button @click="closeModal" class=" text-white hover:underline focus:outline-none
                        rounded-full">Aceptar</button>
            </div>
        </div>
    </div>
</template>
<style></style>

<script>
export default {
    data() {
        return {
            formData: {
                rejected_reason: 0,
                comments: null
            }
        }
    },
    methods: {
        closeModal() {
            window.location.reload();
        }
    }
}
</script>

<style>
.inputs_permutas {
    border-radius: 0.375rem;
    background-color: #f8f8fc;
    border: none;
    padding: 15px 10px;
    color: black;
    /* Input text color */
}

.inputs_permutas::placeholder {
    color: gray;
    /* Placeholder text color */
}
</style>
