const StartChat = () => {
  return (
    <div className="chat chat-start">
      <div className="chat-image avatar">
        <div className="w-10 rounded-full">
          <img src="pp/bill.jpeg" />
        </div>
      </div>
      <div className="chat-header">
        <p>Correspondant</p>
      </div>
      <div className="chat-bubble">You were the Chosen One!</div>
      <time className="chat-footer opacity-50">12h35</time>
    </div>
  );
};
export default StartChat;
