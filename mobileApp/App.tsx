import * as React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import Messages from './src/screens/Messages';
import Settings from './src/screens/Settings';
import NewDiscussion from './src/screens/NewDiscussion';

import { createBottomTabNavigator } from '@react-navigation/bottom-tabs';
import { EnvelopeIcon as Message } from "react-native-heroicons/mini";
import { PlusCircleIcon as Create } from "react-native-heroicons/mini";
import { Cog6ToothIcon as SettingsIcon } from "react-native-heroicons/mini";





const Tab = createBottomTabNavigator();


export default function App() {
  return (
    <NavigationContainer>
      <Tab.Navigator initialRouteName="Messages"
      screenOptions={{
        tabBarShowLabel : false,
        tabBarStyle: {
          height: 70,
          borderTopWidth: 0,
          backgroundColor: '#F2F2F2',
        }
      }}
      
      >
        <Tab.Screen name="Messages" component={Messages} 
        options={{
          tabBarIcon: () => (
            <Message color="red" />
          ),
          headerShown: false

        }}/>
        <Tab.Screen name="Créer" component={NewDiscussion}
        options={{
          tabBarIcon: () => (
            <Create color="red" />
          ),
          headerShown: false
        }} />
        <Tab.Screen name="Settings" component={Settings} 
        options={{
          tabBarIcon: () => (
            <SettingsIcon color="red" />
          ),
          headerShown: false
        }}/>
      </Tab.Navigator>
    </NavigationContainer>
  );
}