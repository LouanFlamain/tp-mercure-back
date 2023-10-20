import { createSlice, PayloadAction } from "@reduxjs/toolkit";

const initialState = null;

export const roomSlice = createSlice({
  name: "room", // Utilisé en interne pour nommer mes actions
  initialState: initialState, // Mon état initial
  reducers: {
    // Tous mes reducers
    declareRoom: (state, action) => {
      return action.payload;
    },
  },
});

export const { declareRoom } = roomSlice.actions;

export default roomSlice.reducer;

export const selectRoom = (state) => state.room;
