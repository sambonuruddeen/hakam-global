<script setup lang="ts">
import { Form } from '@inertiajs/vue3'
import { Input } from '@/components/ui/input'

</script>

<template>
     
    <Form action="/save-asset" method="post" class="space-y-4">
        <div class="flex flex-col">
            <label for="name" class="text-sm font-medium">Asset Name</label>
            <Input type="text" id="name" name="name" placeholder="Asset Name" />
        </div>
        <div class="flex flex-col">
            <label for="description" class="text-sm font-medium">Description</label>
            <input type="text" name="description" id="description" class="border rounded-md p-2" />
        </div>
        <div class="flex flex-col">
            <label for="conditions" class="text-sm font-medium">Conditions</label>
            <input type="text" name="conditions" id="conditions" class="border rounded-md p-2" />
        </div>
        <button type="submit" class="bg-blue-500 text-white rounded-md p-2">Create Asset</button>
    </Form>

</template>
