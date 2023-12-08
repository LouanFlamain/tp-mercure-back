import React from 'react';
import { useNavigation } from '@react-navigation/native';
import { Button, SafeAreaView, StyleSheet, Text, View } from 'react-native';
import SearchBar from '../components/SearchBar';
import AvatarItem from '../components/Avatar';

function Messages(): JSX.Element {
  const navigation = useNavigation();

  const handleLogin = () => {
    navigation.navigate('Login' as never);
  };

  const handleSearch = (searchValue : string) => {
    // Implémente la logique de recherche ici
    console.log(`Recherche en cours pour : ${searchValue}`);
  };
  const OnPress = () =>{
    console.log("changer la photo")
  }

  return (
    <SafeAreaView style={styles.container}>
      <View style={styles.title}>
        <Text>Messages</Text>
      </View>
      <View style={styles.messagesContainer}>
      <SearchBar onSearch={handleSearch} variant="light" placeholder={"Cherchez une discussion"}/>
        <Button title="Login" onPress={handleLogin} />
        <AvatarItem size={"large"} OnPress={OnPress}  />
      </View>
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  container: {
    flexDirection: 'column',
    flex: 1,
    backgroundColor:'lightblue'
  },
  title: {
    flex: 0.15, 
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'none',
  },
  messagesContainer: {
    flex: 0.85, 
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: 'red',
    borderTopLeftRadius:20,
    borderTopRightRadius:20
  },
});

export default Messages;
