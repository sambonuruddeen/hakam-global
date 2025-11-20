<script setup lang="ts">
import 'leaflet/dist/leaflet.css';
import { LMap, LTileLayer } from '@vue-leaflet/vue-leaflet';
import { onMounted, ref, watch } from 'vue';
import L from 'leaflet';
import 'leaflet.heat';

// Extend Leaflet types to include heatLayer
declare module 'leaflet' {
  function heatLayer(latlngs: HeatmapPoint[], options?: any): HeatLayer;
  
  class HeatLayer extends Layer {
    setLatLngs(latlngs: HeatmapPoint[]): this;
  }
}

type HeatmapPoint = [number, number, number?];

const props = defineProps<{
  heatmapData: HeatmapPoint[];
}>();

const zoom = ref(12);
const center = ref<[number, number]>([9.8966, 8.8547]);
let mapInstance: L.Map | null = null;
let heatLayer: L.HeatLayer | null = null;

const onMapReady = (map: L.Map) => {
  mapInstance = map;
  // Add small delay to ensure map is fully ready
  setTimeout(() => {
    updateHeatmap(props.heatmapData);
  }, 100);
};

const updateHeatmap = (data: HeatmapPoint[]) => {
  if (!mapInstance) return;
  
  // Remove existing heat layer
  if (heatLayer) {
    mapInstance.removeLayer(heatLayer);
    heatLayer = null;
  }
  
  if (data && data.length > 0) {
    console.log(`Creating heatmap with ${data.length} concentrated points`);
    
    // Optimized settings for concentrated areas
    heatLayer = L.heatLayer(data, {
      radius: 70,           // Smaller radius for precise concentration
      blur: 15,            // Moderate blur to show density
      maxZoom: 18,         // Allow closer zoom
      minOpacity: 0.4,     // Ensure visibility
      max: 1.0,            // Normalize intensity
      gradient: {
        0.1: 'blue',       // Lower intensity
        0.3: 'cyan',
        0.5: 'lime',
        0.7: 'yellow',
        0.9: 'red'         // Higher concentration
      }
    }).addTo(mapInstance);
    
    // For concentrated data, set a reasonable zoom level around the area
    if (data.length > 0) {
      const firstPoint: [number, number] = [data[0][0], data[0][1]];
      mapInstance.setView(firstPoint, 14); // Zoom closer to see density
    }
  }
};

// Watch for data changes
watch(
  () => props.heatmapData,
  (newData) => {
    updateHeatmap(newData);
  },
  { deep: true }
);

onMounted(() => {
  // Handle case where data loads after component mount
  if (props.heatmapData && props.heatmapData.length > 0) {
    setTimeout(() => updateHeatmap(props.heatmapData), 500);
  }
});

</script>
<template>
    <div class="relative flex h-full flex-col overflow-hidden rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border">
         <h3 class="mb-2 flex-shrink-0 text-lg font-semibold">Field Activity</h3>
        <l-map ref="map" v-model:zoom="zoom" :center="center" @ready="onMapReady" class="flex-grow">
            <l-tile-layer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                layer-type="base"
                name="OpenStreetMap"
            ></l-tile-layer>
        </l-map>
    </div>
</template>